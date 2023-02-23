<template>
  <div class="form-input">
    <label>{{ sLabel }}</label>
    <input
      type="number"
      size="40"
      maxlength="50"
      v-model="valor"
    />
    <div class="underline"></div>
  </div>
</template>
<script>
export default {
  name: "FormNumber",
  props: {
    value: {},
    sLabel: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      valor: ''
    }
  },  
  watch: {
    valor(newValor) {
      this.$emit('updateValor', newValor)
    },
    value(newValue) {
      this.valor = newValue;
    }
  },
  mounted() {
    this.valor = this.value;
  }
}
</script>