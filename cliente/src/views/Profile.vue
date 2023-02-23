<template>
  <div>
    <Header />
    <div class="admin-container">
      <section class="body-info-section">
        <div class="content-section-info">
          <Title :title="'Perfíl de Usuario'" />
          <div class="border-box" style="padding: 0">
            <div class="title-info-row">
              <h2>Información Personal</h2>
            </div>
            <div class="row-info-box cursor-none">
              <div class="first-column">NOMBRE</div>
              <div class="last-column">{{ sessionUser.nombres }}</div>
            </div>
            <div class="row-info-box cursor-none">
              <div class="first-column">DOCUMENTO</div>
              <div class="last-column">{{ sessionUser.documento }}</div>
            </div>
            <div class="row-info-box cursor-none">
              <div class="first-column">TELÉFONO</div>
              <div class="last-column">{{ sessionUser.telefono }}</div>
            </div>
            <div class="row-info-box cursor-none">
              <div class="first-column">DIRECCIÓN</div>
              <div class="last-column">{{ sessionUser.direccion }}</div>
            </div>
            <div class="row-info-box cursor-none">
              <div class="first-column">CIUDAD</div>
              <div class="last-column">{{ sessionUser.ciudad }}</div>
            </div>
          </div>
          <div class="border-box" style="padding: 0; margin-top: 1rem">
            <div class="title-info-row">
              <h2>Información de acceso</h2>
            </div>
            <div class="row-info-box">
              <div class="first-column">CORREO</div>
              <div class="last-column">{{ sessionUser.email }}</div>
            </div>
            <div class="row-info-box">
              <div class="first-column" style="width: 15rem;">CONTRASEÑA</div>
              <div class="last-column">************</div>
              <div class="password-column">
                <button class="btn-change-password" @click="bFormPassword = true">CAMBIAR CONTRASEÑA</button>
              </div>
            </div>
          </div>
          <div
            style="display: flex; justify-content: flex-end; margin-top: 0.5rem"
          >
            <button class="btn-udate" @click="()=>{
                bFormPerfil = true;
                oGetProfile();
            }">EDITAR PERFÍL</button>
          </div>
        </div>
      </section>
    </div>

    <div
      v-if="bFormPassword"
        style="display: flex;justify-content: center;position: fixed;top: 10rem;z-index: 100;width: 100%;"
      >
      <div class="formulario-registro">
        <p class="titulo">Actualización de contraseña</p>
        <button
          class="cross-btn"
          @click="
            () => {
              bFormPassword = false;
            }
          "
        >
          ×
        </button>
        <div class="row">
          <FormPassword
            sLabel="Contraseña Actual"
            :value="sCurrentPassword"
            @updateValor="onSetCurrentPassword($event)"
          />
        </div>
        <div class="row">
          <FormPassword
            sLabel="Nueva Contraseña"
            :value="sNewPassword"
            @updateValor="onSetNewPassword($event)"
          />
          <FormPassword
            sLabel="Confirmar Contraseña"
            :value="sConfirmNewPassword"
            @updateValor="onSetConfirmNewPassword($event)"
          />
        </div>
        <div class="btn-actions">
          <button
            @click="
              () => {
                bFormPassword = false;
              }
            "
          >
            Cancelar
          </button>
          <button @click="onActualizarContrasena(sessionUser.id)">Guardar</button>
        </div>
      </div>
    </div>


    <div
      v-if="bFormPerfil"
        style="display: flex;justify-content: center;position: fixed;top: 10rem;z-index: 100;width: 100%;"
      >
      <div class="formulario-registro">
        <p class="titulo">Actualización de Perfíl</p>
        <button
          class="cross-btn"
          @click="
            () => {
              bFormPerfil = false;
            }
          "
        >
          ×
        </button>
        <div class="row">
          <FormNumber
            sLabel="Documento"
            :value="nDocumento"
            @updateValor="onSetDocumento($event)"
          />
          <FormText
            sLabel="Nombres"
            :value="sNombres"
            @updateValor="onSetNombres($event)"
          />
          <FormNumber
            sLabel="Teléfono"
            :value="nTelefono"
            @updateValor="onSetTelefono($event)"
          />
        </div>
        <div class="row">
          <FormText
            sLabel="Dirección"
            :value="sDireccion"
            @updateValor="onSetDireccion($event)"
          />
          <FormText
            sLabel="Ciudad"
            :value="sCiudad"
            @updateValor="onSetCiudad($event)"
          />
        </div>
        <div class="row">
          <FormText
            sLabel="Email"
            :value="sEmail"
            @updateValor="onSetEmail($event)"
          />
        </div>
        <div class="btn-actions">
          <button
            @click="
              () => {
                bFormPerfil = false;
              }
            "
          >
            Cancelar
          </button>
          <button @click="oActualizarPerfil()">Guardar</button>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>
<script>
import axios from 'axios';
import Header from "@/components/AdminHeader.vue";
import Footer from "@/components/AdminFooter.vue";
import Title from "@/components/page/Title.vue";

import FormText from '@/components/form/components/FormText';
import FormNumber from '@/components/form/components/FormNumber';
import FormPassword from '@/components/form/components/FormPassword';

import { mapState, mapMutations} from "vuex";

export default {
  name: "Profile",
  components: {
    Header,
    Footer,
    Title,
    FormText,
    FormNumber,
    FormPassword
  },
  data: function () {
    return {
        nId: '',
        nDocumento: '',
        sNombres: '',
        nTelefono: '',
        sEmail: '',
        sDireccion: '',
        sCiudad: '',

        sNewPassword: '',
        sCurrentPassword: '',
        sConfirmNewPassword: '',

        bFormPerfil: false,
        bFormPassword: false
    };
  },
  methods: {
    onSetNombres(value) {
        this.sNombres = value;
    },
    onSetDocumento(value) {
        this.nDocumento = value;
    },
    onSetTelefono(value) {
        this.nTelefono = value;
    },
    onSetDireccion(value) {
        this.sDireccion = value;
    },
    onSetCiudad(value) {
        this.sCiudad = value;
    },
    onSetEmail(value) {
        this.sEmail = value;
    },


    onSetCurrentPassword (value) {
      this.sCurrentPassword = value;
    },
    onSetNewPassword (value) {
      this.sNewPassword = value;
    },
    onSetConfirmNewPassword (value) {
      this.sConfirmNewPassword = value;
    },
    oGetProfile() {
        axios.get('http://127.0.0.1:8000/api/auth/me', 
        { headers: { "Authorization": "Bearer " + localStorage.getItem('token')} })
        .then(({data}) => {
            this.nId = data.data.id;
            this.nDocumento = data.data.documento;
            this.sNombres = data.data.nombres;
            this.nTelefono = data.data.telefono;
            this.sEmail = data.data.email;
            this.sDireccion = data.data.direccion;
            this.sCiudad = data.data.ciudad;
        }).catch(e => {
            console.log(e)
        });
    },

    onActualizarContrasena(id) {
      let oData = {
        cur_password : this.sCurrentPassword,
        new_password : this.sNewPassword,
        confirm_password : this.sConfirmNewPassword
      }

      if(!oData.cur_password.trim() || !oData.new_password)
        return this.launchAlert({type: 'error', message: 'Rellena todos los campos'})

      axios.post("http://127.0.0.1:8000/api/user/change-password/" + id, oData, {
        headers: { Authorization: "Bearer " + localStorage.getItem("token"), },
      }).then(()=> {
          this.bFormPassword = false;
          this.sNewPassword = '';
          this.sNewPassword = '';
          this.sCurrentPassword = '';
          return this.launchAlert({
              type: "success",
              title: "¡Contraseña actualizada exitosamente!",
          });
      }).catch(e => {
          this.launchAlert({type: 'error', title: e.response.data.message})
      });
    },

    oActualizarPerfil() {
        let oData = {
            id:         this.nId,
            documento:  this.nDocumento,
            nombres:    this.sNombres,
            telefono:   this.nTelefono,
            email:      this.sEmail,
            direccion:  this.sDireccion,
            ciudad:     this.sCiudad,
        }

        if(!this.isValidEmail(oData.email))
            return this.launchAlert({type: 'warning', title: '¡El correo no es válido!'})

        axios.post("http://127.0.0.1:8000/api/user/update/" + oData.id, oData, {
            headers: { Authorization: "Bearer " + localStorage.getItem("token"), },
        }).then(()=> {
            this.bFormPerfil = false;
            this.loadSessionUser({force: true});
            return this.launchAlert({
                type: "success",
                title: "¡Perfíl actualizado exitosamente!",
            });
        }).catch(e => {
            this.launchAlert({type: 'error', title: e.response.data.message})
        });
    },
    launchAlert(config) {
      if (!config.timeout) config.timeout = 2500;
      const Toast = this.$swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: config.timeout,
      });
      Toast.fire({
        icon: config.type,
        title: config.title,
        text: config.message,
      });
    },
    isValidEmail(email) {
        let re = /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i
        if (re.test(email)) return true
        else return false
    },
	  ...mapMutations(['loadSessionUser']),
  },
  computed: {
    ...mapState(["sessionUser"]),
  },
  mounted() {
  },
};
</script>
<style scoped>
.title-info-row {
  padding: 1.3rem 1rem 0.7rem 1rem;
}
.title-info-row h2 {
  font-weight: 100;
  font-size: 1.2rem;
  color: #7a7a7a;
}

.row-info-box.cursor-none {
  cursor: pointer;
}
.title-info-box,
.box-info-row {
  color: #585858;
}
.row-info-box {
  cursor: pointer;
  display: flex;
  gap: 2rem;
  padding: 1.2rem 1rem;
  border-bottom: 1px solid var(--light-gray-color);
}
.row-info-box:hover {
  background-color: #f8f8f8;
}
.row-info-box:last-child {
  border-bottom: 0;
}
.row-info-box .first-column {
  display: flex;
  align-items: center;
  width: 15%;
  font-size: 0.8rem;
  letter-spacing: 0.05rem;
}
.row-info-box .last-column {
  font-size: 1em;
  display: flex;
  justify-content: center;
  align-items: center;
}

.wrapper-form-data .input-data input.wrong-email {
  border-bottom: 2px solid var(--title-clr);
}
.wrapper-form-data {
  margin: 5px 0;
}
.border-box {
  padding: 1.5rem 1.8rem;
}
.row-box {
  display: grid;
  gap: 10px;
  grid-template-columns: repeat(auto-fit, minmax(min(100%, 25rem), 1fr));
}
select.form-control {
  padding: 5px;
  border-radius: 2px;
  outline: none;
  border: solid 2px rgb(180, 180, 180);
}

.btn-udate {
  width: 100%;
  border: solid 2px #0056a0;
  padding: 0.5rem 1rem;
  color: #0056a0;
  background: #ffffff;
  border-radius: 2px;
  cursor: pointer;
}

.btn-change-password {
  border: solid 2px #5c5c5c;
  padding: 0.5rem 1rem;
  color: #5c5c5c;
  background: #ffffff;
  border-radius: 2px;
  cursor: pointer;
}

.password-column{
  width: 100%;
  display: flex;
  justify-content: flex-end;
}
</style>