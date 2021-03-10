const numberFormat = new Intl.NumberFormat('ru-RU',
  { minimumFractionDigits: 2 });

export default () => ({ currencyFormat: numberFormat.format });
