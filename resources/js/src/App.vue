<template>
  <ion-page>
    <router-view/>

    <ion-segment @ionChange="segmentChanged($event)" value="input_values" color="secondary">
      <ion-segment-button value="input_values">
        <ion-label>Input values</ion-label>
      </ion-segment-button>
      <ion-segment-button value="calculate">
        <ion-label>Calculate</ion-label>
      </ion-segment-button>
      <ion-segment-button value="payment_schedule">
        <ion-label>Payment schedule</ion-label>
      </ion-segment-button>
    </ion-segment>
  </ion-page>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import {
  IonPage,
  IonSegment,
  IonSegmentButton,
  IonToolbar,
} from '@ionic/vue';

@Options({
  components: {
    IonPage,
    IonSegment,
    IonSegmentButton,
    IonToolbar,
  },
})
export default class App extends Vue {
  consoleTitle = 'Segment changed'

  segmentChanged(ev: CustomEvent) {
    console.log(this.consoleTitle, ev);
  }
}
</script>

<style lang="scss">
</style>
