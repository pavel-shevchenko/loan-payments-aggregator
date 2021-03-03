<template>
  <ion-header>
    <ion-toolbar>
      <ion-title>Enter Parameters
        <span v-if="currentRate"> (Current interest rate: {{ currentRate }}%)</span>
      </ion-title>
    </ion-toolbar>
  </ion-header>

  <ion-list>
    <ion-item v-if="banks">
      <ion-label>Bank</ion-label>
      <ion-select
        v-model="bankIndex"
        ok-text="Select bank"
        cancel-text="Cancel">
        <ion-select-option
          v-for="(bank, index) in banks"
          :key="index"
          :value="index">{{ bank.name }}</ion-select-option>
      </ion-select>
    </ion-item>

    <ion-item v-if="banks">
      <ion-label>Type</ion-label>
      <ion-select
        v-model="typeIndex"
        ok-text="Select type"
        cancel-text="Cancel">
        <ion-select-option
          v-for="(offer, index) in mortgageOffers"
          :key="index"
          :value="index">{{ capitalize(offer.type) }}</ion-select-option>
      </ion-select>
    </ion-item>

    <ion-item v-if="allowedPurposes">
      <ion-label>Purpose</ion-label>
      <ion-select
        v-model="purposeIndex"
        ok-text="Select purpose"
        cancel-text="Cancel">
        <ion-select-option
          v-for="(purpose, index) in allowedPurposes"
          :key="index"
          :value="index">{{ purpose.title }}</ion-select-option>
      </ion-select>
    </ion-item>

    <ion-item v-for="(discount, index) in allowedDiscounts" :key="discount.uniqueId">
      <ion-label>{{ discount.title }}</ion-label>
      <ion-toggle
        @click="toggleSelectDiscount(index)"
        :checked="isDiscountSelected(index) && ionToggleIsResetBugFix">
      </ion-toggle>
    </ion-item>

    <ion-item v-if="costMin && costStep && costMax && costSelected">
      <ion-label>House full cost</ion-label>
      <ion-range :min="costMin"
                 :step="costStep"
                 :max="costMax"
                 v-model="costSelected"
                 :debounce="200"
                 :pin="true"
                 :snaps="true"
                 :ticks="true"></ion-range>
    </ion-item>

    <ion-item v-if="initLoanMin && initLoanStep && initLoanMax && initLoanSelected">
      <ion-label>Init loan payment</ion-label>
      <ion-range :min="initLoanMin"
                 :step="initLoanStep"
                 :max="initLoanMax"
                 v-model="initLoanSelected"
                 :debounce="200"
                 :pin="true"
                 :snaps="true"
                 :ticks="true"></ion-range>
    </ion-item>

    <ion-item v-if="loanTermMin && loanTermMax && loanTermSelected">
      <ion-label>Loan term in years</ion-label>
      <ion-range :min="loanTermMin"
                 :step="1"
                 :max="loanTermMax"
                 v-model="loanTermSelected"
                 :debounce="200"
                 :pin="true"
                 :snaps="true"
                 :ticks="true"></ion-range>
    </ion-item>

  </ion-list>
</template>

<script lang="ts">
import {
  defineComponent,
  watch,
  ref,
  Ref,
} from 'vue';
import {
  IonHeader,
  IonItem,
  IonLabel,
  IonList,
  IonSelect,
  IonSelectOption,
  IonRange,
} from '@ionic/vue';
import { useQuery, useResult } from '@vue/apollo-composable';
import getInitDataQuery from '../graphql/mortgage_aggregation.query.gql';
import useCalcParams from '../use/calcParamsState';

export default defineComponent({
  components: {
    IonHeader,
    IonItem,
    IonLabel,
    IonList,
    // IonListHeader,
    IonSelect,
    IonSelectOption,
    IonRange,
  },
  setup(props) {
    // Declaring reactive variables and setting them to default template refs
    const bankIndex: Ref<number> = ref(0);
    const typeIndex: Ref<number> = ref(0);
    const purposeIndex: Ref<number> = ref(0);
    const costMin: Ref<number> = ref(0);
    const costStep: Ref<number> = ref(0);
    const costMax: Ref<number> = ref(0);
    const costSelected: Ref<number> = ref(0);
    const initLoanMin: Ref<number> = ref(0);
    const initLoanStep: Ref<number> = ref(0);
    const initLoanMax: Ref<number> = ref(0);
    const initLoanSelected: Ref<number> = ref(0);
    const loanTermMin: Ref<number> = ref(0);
    const loanTermMax: Ref<number> = ref(0);
    const loanTermSelected: Ref<number> = ref(0);
    const currentRate: Ref<number> = ref(0);
    const mortgageOffers: Ref = ref();
    const currMortgageOffer: Ref = ref();
    const allowedPurposes: Ref = ref();
    const currLoanPurpose: Ref = ref();
    const allowedDiscounts: Ref = ref();
    const selectedDiscountIndexes: Ref = ref([]);
    const ionToggleIsResetBugFix: Ref = ref(true);
    // Use stored calculation parameters
    const {
      setType,
      setRate,
      setLoanAmount,
      setLoanTerm,
    } = useCalcParams();

    // Set form data and do related mutations in the calc params store after change bank or type
    const setDataAndDoMutations = () => {
      purposeIndex.value = 0;
      selectedDiscountIndexes.value = [];
      ionToggleIsResetBugFix.value = true;
      setType(currMortgageOffer.value.type);
      costMin.value = currMortgageOffer.value.cost_min;
      costStep.value = currMortgageOffer.value.cost_step;
      costMax.value = currMortgageOffer.value.cost_max;
      costSelected.value = costMin.value + costStep.value * Math.floor(
        (costMax.value - costMin.value) / 2 / costStep.value,
      );
      initLoanMin.value = currMortgageOffer.value.init_loan_min;
      initLoanStep.value = currMortgageOffer.value.init_loan_step;
      initLoanMax.value = costSelected.value;
      initLoanSelected.value = initLoanMin.value + initLoanStep.value * Math.floor(
        (initLoanMax.value - initLoanMin.value) / 2 / initLoanStep.value,
      );
      loanTermMin.value = currMortgageOffer.value.term_min;
      loanTermMax.value = currMortgageOffer.value.term_max;
      loanTermSelected.value = loanTermMin.value
        + Math.floor((loanTermMax.value - loanTermMin.value) / 2);
    };

    // Request to the server
    const { result } = useQuery(getInitDataQuery);
    const banks: Ref = useResult(result, null, (response) => response.banks.data);
    // Initialization after server response
    watch(banks, () => {
      mortgageOffers.value = banks.value[0].mortgageOffers;
      currMortgageOffer.value = mortgageOffers.value[typeIndex.value];
      setDataAndDoMutations();
    });
    // Calculate overall discount function
    const getDiscount = (): number => selectedDiscountIndexes.value.reduce(
      (accumulator: number, discountIndex: number) => (
        accumulator + allowedDiscounts.value[discountIndex].discountDetails.reduction_value
      ), 0,
    );

    // Interdependent watcher groups:
    // 1). Current selected mortgage offer by its index
    watch([mortgageOffers, typeIndex], () => {
      if (mortgageOffers.value) {
        currMortgageOffer.value = mortgageOffers.value[typeIndex.value];
      }
    });
    // 2). Current allowed loan purposes and rate discounts
    watch(currMortgageOffer, () => {
      allowedPurposes.value = currMortgageOffer.value.loanPurposes;
      allowedDiscounts.value = currMortgageOffer.value.rateDiscounts.map(
        // Add unique identifier for correct re-rendering
        (discount: any) => ({ ...discount, uniqueId: Math.random().toString(16).slice(2) }),
      );
    });
    // 3). Current selected purpose by its index
    watch([allowedPurposes, purposeIndex], () => {
      if (allowedPurposes.value) {
        currLoanPurpose.value = allowedPurposes.value[purposeIndex.value];
      }
    });
    // 4). Current interest rate by selected loan purpose (computing and storing)
    watch([currLoanPurpose, selectedDiscountIndexes], () => {
      if (currLoanPurpose.value) {
        currentRate.value = currLoanPurpose.value.purposeDetails.base_rate - getDiscount();
        setRate(currentRate.value);
      }
    });

    // Type of loan payments changed, which means that the current mortgage offer also changes
    watch(typeIndex, setDataAndDoMutations);
    // Bank changed
    watch(bankIndex, () => {
      mortgageOffers.value = banks.value[bankIndex.value].mortgageOffers;
      typeIndex.value = 0;
      setDataAndDoMutations();
    });
    // Limit the maximum initial loan payment to the cost of housing
    watch(costSelected, () => {
      initLoanMax.value = costSelected.value;
    });
    // Storing loan amount
    watch([costSelected, initLoanSelected], () => {
      setLoanAmount(costSelected.value - initLoanSelected.value);
    });
    // Storing loan term
    watch(loanTermSelected, () => {
      setLoanTerm(loanTermSelected.value);
    });

    return {
      banks,
      mortgageOffers,
      bankIndex,
      typeIndex,
      purposeIndex,
      allowedPurposes,
      allowedDiscounts,
      selectedDiscountIndexes,
      currentRate,
      costMin,
      costStep,
      costMax,
      costSelected,
      initLoanMin,
      initLoanStep,
      initLoanMax,
      initLoanSelected,
      loanTermMin,
      loanTermMax,
      loanTermSelected,
      ionToggleIsResetBugFix,
    };
  },
  methods: {
    // Helpers
    capitalize(value: any): string {
      if (value === '') return '';
      const valueString: string = value.toString();
      return valueString.charAt(0).toUpperCase() + valueString.slice(1);
    },
    toggleSelectDiscount(index: number): void {
      this.ionToggleIsResetBugFix = false;
      this.selectedDiscountIndexes = this.isDiscountSelected(index)
        ? this.selectedDiscountIndexes.filter((el: number) => el !== index)
        : [...this.selectedDiscountIndexes, index];
    },
    isDiscountSelected(index: number): boolean {
      return this.selectedDiscountIndexes.includes(index);
    },
  },
});
</script>
