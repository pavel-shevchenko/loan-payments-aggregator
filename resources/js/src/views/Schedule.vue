<template>
  <ion-header>
    <ion-toolbar>
      <ion-title>Schedule</ion-title>
    </ion-toolbar>
  </ion-header>

  <br />

  <ion-list>
    <ion-item>
      <table id="rwd-table">
        <thead>
          <tr>
            <th>Monthly</th>
            <th>Interest</th>
            <th>Principal</th>
            <th>Debt</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(payment, index) in payments" :key="index">
            <td>{{ currencyFormat(payment.monthlyPayment) }}</td>
            <td>{{ currencyFormat(payment.interestDebtPay) }}</td>
            <td>{{ currencyFormat(payment.principalDebtPay) }}</td>
            <td>{{ currencyFormat(payment.monthlyLoanAmount) }}</td>
          </tr>
        </tbody>
      </table>
    </ion-item>
  </ion-list>
</template>
<script lang="ts">
import {
  defineComponent,
  ref,
  Ref,
  onMounted,
} from 'vue';
import {
  IonHeader,
  IonList,
  IonItem,
} from '@ionic/vue';
import { useRouter, useRoute } from 'vue-router';
import useCalculation from '../use/calculationState';
import useFormat from '../use/format';

export default defineComponent({
  components: {
    IonHeader,
    IonList,
    IonItem,
  },
  setup(props) {
    // Use stored calculation parameters and schedule
    const {
      loanAmount,
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
    loadSchedule();

    return {
      payments,
      currencyFormat,
    };
  },
});
</script>

<style lang="scss">
$primary-color: #3880ff;
$gray-color: #ddd;
$medium-up: 600px;
$large-up: 1000px;
$global-radius: 4px;

@mixin heading-font-regular {
  font-family: 'Helvetica', 'Helvetica Neue', 'Arial', sans-serif;;
}

///BASIC TABLE STYLING
table {
  border-collapse: collapse;
  width: 100%;
  float: left;
  margin: 0 0 2em;
  thead {
    border-bottom: 3px solid $primary-color;
    th {
      padding: 0.35em 0 .35em;
      font-weight: 400;
      text-align: left;
      @include heading-font-regular;
      font-size: 1.25em;
    }

  }

  tbody {
    border-bottom: 3px solid $primary-color;
    tr {
      border-bottom: 2px solid #ddd;

      td {
        padding: .75em 0;

        a {
          color: $primary-color;
          text-decoration: none;
          display: inline-block;
          margin: 0 .5em 0 0;
          &:hover, &:active, &:focus {
            color: darken($primary-color, 10%);
            border: none;
          }
        }
      }
    }
  }

  tfoot {
    td {
      padding: 0.35em 0 .35em;

      text-align: left;
      @include heading-font-regular;
      font-size: 1.25em;
    }
  }
}

@media screen and (min-width: $large-up) {
  table {
    width: 100%;

    thead {
      border-bottom: 3px solid $primary-color;
      th {
      }

    }

    tbody {
      tr {
        border-bottom: 1px solid #ddd;
        td {

        }
      }
    }
  }
}

///RWD MIXIN BELOW
@mixin rwd-first {
  display: block;

  tbody {
    border: none;
  }
  tbody, th, td, tr, tfoot {
    display: block;
  }

  thead {
    display: none;
  }
  tr {
    float: left;
    width: 100%;
    margin: 0 0 1em;
    border: 1px solid $gray-color;
    box-shadow: 0px 2px 5px 0px $gray-color;
    border-radius: $global-radius;
    border-top: 5px solid $primary-color;

    td {
      padding: .5em .5em .5em 50%;
      float:left;
      width: 100%;
      &:before {
        width: 100%;
        display: block;
        float: left;
        padding: .5em .5em .5em 0;
        clear: both;
        margin: -.5em 0 0 -100%;
        @include heading-font-regular;
        font-size: 1.125em;

      }
    }
  }

  tr:nth-of-type(even) {
    //background: $gray-color;
    td {

      &:before {

      }
    }
  }
}

@mixin rwd-second {
  display: table;
  border: none;

  tbody {
    border-bottom: 3px solid $primary-color;
  }
  th, td {
    display: table-cell;
  }

  tr {
    display: table-row;
    border: none;
    border-bottom: 1px solid #eee;
    float: none;
    margin: 0;
    box-shadow: none;

    td {
      padding: .75em 0 0.75em .25em;
      float: none;
      width: auto;

      &:before {
        padding: 0 !important;
      }
    }
  }

  thead {
    display: table-header-group;
  }

  tbody,tfoot {
    display: table-row-group;
  }

  tr:nth-of-type(even) {
    background:none;
    td {

      &:before {

      }
    }
  }
}

%responive-tables {
  @include rwd-first;

  @media screen and (min-width: $medium-up) {
    @include rwd-second;

  }
}

%responive-tables-large {
  @include rwd-first;

  @media screen and (min-width: $large-up) {
    @include rwd-second;

  }
}

@mixin responive-tables($headings...) {
  $list: $headings;

  @each $list-headings in $list {
    $i: index($list, $list-headings);
    tbody tr td:nth-of-type(#{$i}):before {
      content: $list-headings;
    }

    @media screen and (min-width: $medium-up) {
      tbody tr td:nth-of-type(#{$i}):before {
        content: '';
      }
    }

  }
}

@mixin responive-tables-large($headings...) {
  $list: $headings;

  @each $list-headings in $list {
    $i: index($list, $list-headings);
    tbody tr td:nth-of-type(#{$i}):before {
      content: $list-headings;
    }

    @media screen and (min-width: $large-up) {
      tbody tr td:nth-of-type(#{$i}):before {
        content: '';
      }
    }

  }
}

#rwd-table {
  @extend %responive-tables;
  @include responive-tables('Monthly', 'Interest', 'Principal', 'Debt');
}

#rwd-table-large {
  @extend %responive-tables-large;
  @include responive-tables-large('Monthly', 'Interest', 'Principal', 'Debt');
}
</style>
