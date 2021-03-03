import { ref, Ref, readonly } from 'vue';

const type: Ref = ref();

export default () => {
  const setType = (newType: string): void => {
    type.value = newType;
  };

  return {
    type: readonly(type),
    setType,
  };
};
