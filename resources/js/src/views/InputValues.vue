<template>
  <ion-header>
    <ion-toolbar>
      <ion-title>Input Values</ion-title>
    </ion-toolbar>
  </ion-header>

  <ion-list>
<!--    <ion-list-header>
      <ion-label>
        Single Selection
      </ion-label>
    </ion-list-header>-->

    <ion-item>
      <ion-label>Bank</ion-label>
      <ion-select value="brown" ok-text="Select bank" cancel-text="Cancel">
        <ion-select-option value="brown">Brown</ion-select-option>
        <ion-select-option value="blonde">Blonde</ion-select-option>
        <ion-select-option value="black">Black</ion-select-option>
        <ion-select-option value="red">Red</ion-select-option>
      </ion-select>
    </ion-item>

    <ion-item>
      <ion-label>Purpose</ion-label>
      <ion-select value="brown" ok-text="Okay" cancel-text="Dismiss">
        <ion-select-option value="brown">Brown</ion-select-option>
        <ion-select-option value="blonde">Blonde</ion-select-option>
        <ion-select-option value="black">Black</ion-select-option>
        <ion-select-option value="red">Red</ion-select-option>
      </ion-select>
    </ion-item>

    <ion-item>
      <ion-label>Type</ion-label>
      <ion-select value="brown" ok-text="Okay" cancel-text="Dismiss">
        <ion-select-option value="brown">Brown</ion-select-option>
        <ion-select-option value="blonde">Blonde</ion-select-option>
        <ion-select-option value="black">Black</ion-select-option>
        <ion-select-option value="red">Red</ion-select-option>
      </ion-select>
    </ion-item>

    <ion-item>
      <ion-label>Card</ion-label>
      <ion-toggle
        @ionChange="toppings.value.push($event.target.value)"
        value="sausage"
        :checked="toppings.value.indexOf('pepperoni') !== -1">
      </ion-toggle>
    </ion-item>

    <ion-item>
      <ion-label>Approve</ion-label>
      <ion-toggle
        @ionChange="toppings.value.push($event.target.value)"
        value="sausage"
        :checked="toppings.value.indexOf('pepperoni') !== -1">
      </ion-toggle>
    </ion-item>

    <ion-item>
      <ion-range min="1000" max="2000" step="100" snaps="true"
                 ticks="false" color="secondary"></ion-range>
    </ion-item>

    <ion-item>
      <ion-range ref="rangeDualKnobs" dual-knobs="true" min="21" max="72"
                 step="3" snaps="true"></ion-range>
    </ion-item>

  </ion-list>
</template>

<script>
import {
  IonHeader,
  IonItem,
  IonLabel,
  IonList,
  // IonListHeader,
  IonSelect,
  IonSelectOption,
  IonRange,
} from '@ionic/vue';
import { defineComponent, ref } from 'vue';

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
    const toppings = ref([]);

    return { toppings };
  },
  mounted() {
    // Sets initial value for dual-knob ion-range
    this.$refs.rangeDualKnobs.value = { lower: 24, upper: 42 };
  },
});
</script>
