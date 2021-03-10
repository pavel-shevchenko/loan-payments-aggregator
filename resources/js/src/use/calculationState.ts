import { ref, Ref, readonly } from 'vue';
import { useMutation } from '@vue/apollo-composable';
import calculateScheduleMutation from '../graphql/payments_schedule.mutation.gql';

const type: Ref = ref();
const rate: Ref = ref();
const loanAmount: Ref = ref();
const loanTerm: Ref = ref();
const payments: Ref = ref([]);

export default () => {
  const setType = (newType: string): void => {
    type.value = newType;
    payments.value = [];
  };
  const setRate = (newRate: number): void => {
    rate.value = newRate;
    payments.value = [];
  };
  const setLoanAmount = (newLoanAmount: number): void => {
    loanAmount.value = newLoanAmount;
    payments.value = [];
  };
  const setLoanTerm = (newLoanTerm: number): void => {
    loanTerm.value = newLoanTerm;
    payments.value = [];
  };
  const loadSchedule = async (): Promise<void> => {
    if (payments.value.length > 0) return;
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
  };

  return {
    type: readonly(type),
    rate: readonly(rate),
    loanAmount: readonly(loanAmount),
    loanTerm: readonly(loanTerm),
    payments: readonly(payments),
    setType,
    setRate,
    setLoanAmount,
    setLoanTerm,
    loadSchedule,
  };
};
