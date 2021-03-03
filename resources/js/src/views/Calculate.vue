<template>
  <ion-header>
    <ion-toolbar>
      <ion-title>Calculate</ion-title>
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
        <p>{{ loanAmount }}</p>
      </ion-label>
    </ion-item>

    <ion-item>
      <ion-label class="ion-text-wrap">
        <ion-text color="primary">
          <h3>Monthly payment</h3>
        </ion-text>
        <p>{{ monthlyPayment }}</p>
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
} from 'vue';
import {
  IonHeader,
  IonItem,
  IonLabel,
  IonList,
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
    // Use stored calculation parameters
    const {
      type,
      rate,
      loanAmount,
      loanTerm,
    } = useCalcParams();
    const router = useRouter();
    if (!loanAmount.value) {
      router.push({ name: 'InputValues' });
    }

    return {
      monthlyPayment,
      type,
      rate,
      loanAmount,
      loanTerm,
    };
  },
});
</script>
