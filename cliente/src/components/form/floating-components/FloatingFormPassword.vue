<template>
  <div class="wrapper-form-data pd-1">
    <div class="input-data">
      <input
        size="40"
        maxlength="50"
        required
        :type="show ? 'text' : 'password'"
        v-model="valor"
      />
      <div class="underline"></div>
      <label>Contraseña</label>
    </div>
    <div 
      class="show-input" 
      @click="onShowPassword()"
    >
      <span :class="show ? 'icon-view-hide' : 'icon-view-show'"></span>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'FormPassword',
    props: {
      value: {},
      sLavel: {
        type: String,
        default: '',
      }
    },
    data() {
      return {
        valor: '',
        show: false
      }
    },
    methods: {
      onShowPassword() {
        this.show = !this.show;
      }
    },
    watch: {
      valor(newValor) {
        this.$emit('updateValor', newValor)
      },
      value(newValue) {
        this.value = newValue;
      }
    }
  }

</script>