<template>
  <ion-header>
    <ion-toolbar>
      <ion-title>Calculation</ion-title>
    </ion-toolbar>
  </ion-header>

  <ion-list>
    <ion-item>
      <ion-label class="ion-text-wrap">
        <ion-text color="primary">
          <h3>Interest rate:</h3>
        </ion-text>
        <p>{{ rate }}%</p>
      </ion-label>
    </ion-item>

    <ion-item>
      <ion-label class="ion-text-wrap">
        <ion-text color="primary">
          <h3>Loan amount</h3>
        </ion-text>
        <p>{{ currencyFormat(loanAmount) }}</p>
      </ion-label>
    </ion-item>

    <ion-item>
      <ion-label class="ion-text-wrap">
        <ion-text color="primary">
          <h3>Monthly payment</h3>
        </ion-text>
        <p>{{ type === 'differentiated' ? 'up to ' : '' }}{{ currencyFormat(monthlyPayment) }}</p>
      </ion-label>
    </ion-item>
  </ion-list>
</template>

<script lang="ts">
import {
  defineComponent,
  watch,
  ref,
  Ref,
  onMounted,
} from 'vue';
import {
  IonHeader,
  IonList,
  IonItem,
  IonLabel,
  IonText,
} from '@ionic/vue';
import { useMutation, useResult } from '@vue/apollo-composable';
import { useRouter, useRoute } from 'vue-router';
import calculateScheduleMutation from '../graphql/payments_schedule.mutation.gql';
import useCalcParams from '../use/calcParamsState';

export default defineComponent({
  components: {
    IonHeader,
    IonItem,
    IonLabel,
    IonList,
    IonText,
  },
  setup(props) {
    const monthlyPayment: Ref<number> = ref(0);
    const payments: Ref = ref([]);
    // Use stored calculation parameters
    const {
      type,
      rate,
      loanAmount,
      loanTerm,
    } = useCalcParams();
    // Redirect to input params route if the user went to the page directly
    const router = useRouter();
    if (!loanAmount.value) {
      router.push({ name: 'InputValues' });
    }
    // Request full schedule list of loan payments
    const { mutate: schedule } = useMutation(
      calculateScheduleMutation, () => ({
        variables: {
          type: type.value,
          interestRate: rate.value,
          loanAmount: loanAmount.value,
          loanTerm: loanTerm.value,
        },
      }),
    );
    onMounted(async () => {
      const paymentsResult = await schedule();
      payments.value = paymentsResult.data.schedule;
    });
    // Pick monthly payment on full payments list is loaded
    watch(payments, () => {
      monthlyPayment.value = Math.round(payments.value[0].monthlyPayment);
    });

    return {
      monthlyPayment,
      payments,
      type,
      rate,
      loanAmount,
      loanTerm,
    };
  },
  methods: {
    // Helpers
    currencyFormat: (currency: number): string => currency.toLocaleString(
      undefined,
      { minimumFractionDigits: 2 },
    ),
  },
});
</script>
