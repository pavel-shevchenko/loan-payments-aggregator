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
import { useRouter, useRoute } from 'vue-router';
import useCalculation from '../use/calculationState';
import useFormat from '../use/format';

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
    // Use stored calculation parameters and schedule
    const {
      type,
      rate,
      loanAmount,
      loanTerm,
      payments,
      loadSchedule,
    } = useCalculation();
    // Use currency formatter
    const { currencyFormat } = useFormat();
    // Redirect to input params route if the user went to the page directly
    const router = useRouter();
    if (!loanAmount.value) {
      router.push({ name: 'InputValues' });
    }
    // Pick monthly payment on full payments list is loaded
    const pickMonthlyPayment = () => {
      if (payments.value.length > 0) {
        monthlyPayment.value = Math.round(payments.value[0].monthlyPayment);
      }
    };
    watch(payments, pickMonthlyPayment);
    pickMonthlyPayment();
    loadSchedule();

    return {
      monthlyPayment,
      payments,
      type,
      rate,
      loanAmount,
      loanTerm,
      currencyFormat,
    };
  },
});
</script>
