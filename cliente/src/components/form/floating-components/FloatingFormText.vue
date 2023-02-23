<template>
  <div class="wrapper-form-data pd-1">
    <div class="input-data">
      <input
        type="text"
        name="email"
        size="40"
        maxlength="50"
        required
        v-model="valor"
      />
      <div class="underline"></div>
      <label>{{ sLabel }}</label>
    </div>
  </div>
</template>
<script>
export default {
  name: "FloatingFormText",
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
  }
}
</script>