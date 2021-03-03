import { ref, Ref, readonly } from 'vue';

const type: Ref = ref();
const rate: Ref = ref();
const loanAmount: Ref = ref();
const loanTerm: Ref = ref();

export default () => {
  const setType = (newType: string): void => {
    type.value = newType;
  };
  const setRate = (newRate: number): void => {
    rate.value = newRate;
  };
  const setLoanAmount = (newLoanAmount: number): void => {
    loanAmount.value = newLoanAmount;
  };
  const setLoanTerm = (newLoanTerm: number): void => {
    loanTerm.value = newLoanTerm;
  };

  return {
    type: readonly(type),
    rate: readonly(rate),
    loanAmount: readonly(loanAmount),
    loanTerm: readonly(loanTerm),
    setType,
    setRate,
    setLoanAmount,
    setLoanTerm,
  };
};
