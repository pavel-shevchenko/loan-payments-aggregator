<template>
  <ion-header>
    <ion-toolbar>
      <ion-title>Schedule</ion-title>
    </ion-toolbar>
  </ion-header>
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
} from '@ionic/vue';
import { useMutation, useResult } from '@vue/apollo-composable';
import { useRouter, useRoute } from 'vue-router';
import calculateScheduleMutation from '../graphql/payments_schedule.mutation.gql';
import useCalcParams from '../use/calcParamsState';

export default defineComponent({
  components: {
    IonHeader,
  },
  async setup(props) {
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
    const paymentsResult = await schedule();
    payments.value = paymentsResult.data.schedule;

    return {
      monthlyPayment,
      payments,
      type,
      rate,
      loanAmount,
      loanTerm,
    };
  },
});
</script>
