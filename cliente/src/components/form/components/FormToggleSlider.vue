<template>
  <div class="container">
    <label class="switch">
      <input type="checkbox" v-model="valor"/>
      <div class="slider round"></div>
    </label>
  </div>
</template>
<script>
export default {
  name: 'FormToggleSlider',
  data(){
    return {
      valor: ''
    }
  },
  props: {
    value: {}
  },
  watch : {
    valor(newValor) {
      this.$emit('updateValor', newValor)
    }
  },
  mounted() {
    this.valor = this.value;
  }
}
</script>

<style scoped>
.switch {
  display: inline-block;
  height: 24px;
  position: relative;
  width: 50px;
}

.switch input {
  display:none;
}
.slider {
  background-color: #ccc;
  bottom: 0;
  cursor: pointer;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  transition: .4s;
}

.slider:before {
  background-color: #fff;
  bottom: 4px;
  content: "";
  height: 16px;
  left: 4px;
  position: absolute;
  transition: .4s;
  width: 16px;
}

input:checked + .slider {
  background-color: #6684bb;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

/* general styling */
html, body {
  height: 100%;
  margin: 0;
}

body {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  background-color: #f1f2f3;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
}

.container {
  margin: 0 auto;
}
</style>