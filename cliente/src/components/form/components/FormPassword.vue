<template>
  <div class="form-input">
    <label>{{ sLabel }}</label>
    <div class="container-input" style="display: flex; gap: 1rem;">
      <input
        size="40"
        maxlength="50"
        v-model="valor"
        :type="show ? 'text' : 'password'"
      />
      <div 
        class="show-input" 
        @click="onShowPassword()"
      >
        <span :class="show ? 'icon-view-hide' : 'icon-view-show'"></span>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'FormPassword',
    props: {
      value: {},
      sLabel: {
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
    },
    mounted() {
      this.valor = this.value;
    }
  }

</script>
<style scoped>
.container-input {
  box-sizing: border-box;
	padding: .4rem .5rem;
	border: 0;
	box-shadow: 0 0 1px #000000;
	border-radius: 2px;
}

.container-input input {
  padding: 0;
  box-shadow: none;
}
</style>>