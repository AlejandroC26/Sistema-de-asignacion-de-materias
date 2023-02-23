<template>
  <div>
    <Header />
    <div class="admin-container">
      <section class="body-info-section">
        <div class="content-section-info">
          <Title :title="'Profesores'" />
          <div
            class="btn-confirm primary"
            style="display: flex; justify-content: flex-end"
          >
            <button
              @click="
                () => {
                  register = true;
                  update = false;
                  asignatura = false;
                  limpiarFormulario();
                }
              "
            >
              Nuevo registro
            </button>
          </div>

          <!-- FORMULARIO DE REGISTRO -->
          <div
            style="display: flex; justify-content: center; position: relative"
          >
            <div v-if="register || update" class="formulario-registro">
              <p class="titulo" v-if="update === false">Registro de profesor</p>
              <p class="titulo" v-else>Actualizar profesor</p>
              <button
                class="cross-btn"
                @click="
                  () => {
                    register = false;
                    limpiarFormulario();
                  }
                "
              >
                ×
              </button>
              <div class="row">
                <div class="col">
                  <p>Documento</p>
                  <input type="number" v-model="profesor.documento" />
                </div>
                <div class="col">
                  <p>Nombres</p>
                  <input type="text" v-model="profesor.nombres" />
                </div>
                <div class="col">
                  <p>Teléfono</p>
                  <input type="text" v-model="profesor.telefono" />
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <p>Dirección</p>
                  <input type="text" v-model="profesor.direccion" />
                </div>
                <div class="col">
                  <p>Ciudad</p>
                  <input type="text" v-model="profesor.ciudad" />
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <p>Email</p>
                  <input type="text" v-model="profesor.email" />
                </div>
                <div v-if="update === false" class="col">
                  <p>Contraseña</p>
                  <input type="number" v-model="profesor.password" />
                </div>
              </div>

              <div class="btn-confirm" v-if="update === false">
                <button @click="registrarProfesor(profesor)">Registrar</button>
              </div>
              <div class="btn-confirm" v-else>
                <button @click="actualizarProfesor(profesor)">Guardar</button>
              </div>
            </div>
          </div>

          <!-- ASIGNACIÓN DE MATERIAS -->
          <div
            style="display: flex; justify-content: center; position: relative"
          >
            <div v-if="asignatura" class="formulario-registro">
              <p class="titulo">ASIGNAR MATERIAS</p>
              <button class="cross-btn" @click="asignatura = false">×</button>
              <div class="row">
                <div class="col">
                  <p><b>Nombre:</b> {{ profesor.nombres }}</p>
                </div>
              </div>
              <div class="row">
                <div class="col" style="display: flex">
                  <select v-model="id_asignatura">
                    <option
                      v-for="asignatura in asignaturas"
                      :key="asignatura.id"
                      :value="asignatura.id"
                      v-html="asignatura.nombre"
                    ></option>
                  </select>
                  <button
                    style=" padding: 0.3rem 0.5rem; box-shadow: 0 0 1px #000000; border: none; cursor: pointer;"
                    @click="registrarAsignatura()"
                  >
                    Agregar
                  </button>
                </div>
              </div>
              <div class="row" style="margin-top: 0.5rem">
                <div class="col">
                  <p><b>ASIGNATURAS</b></p>
                </div>
              </div>
              <div v-if="cursos.length > 0">
                <div
                  v-for="curso in cursos"
                  :key="curso.id_ap"
                  class="row-asignatura"
                >
                  <div>
                    Nombre: {{ curso.nombre_asignatura }} <br />
                    Creditos: {{ curso.creditos }}
                  </div>
                  <div><span :class="curso.estado !== 'activo' ? 'span-activo' : 'span-inactivo'">{{ curso.estado }}</span></div>
                  <div>
                    <FormToggleSlider
                      :value="curso.estado === 'activo'"
                      @updateValor="onUpdateEstado({value: $event, id: curso.id_ap})"
                    />
                  </div>
                </div>
              </div>
              <div style="margin: 1rem 1.2rem" v-else>
                No hay asignaturas asignadas
              </div>
            </div>
          </div>

          <table class="styled-table">
            <thead>
              <tr>
                <td>Documento</td>
                <td>Nombres</td>
                <td>Teléfono</td>
                <td>Email</td>
                <td>Dirección</td>
                <td>Ciudad</td>
                <td>Acción</td>
              </tr>
            </thead>
            <tbody>
              <tr v-for="profesor in profesores" :key="profesor.id">
                <td>{{ profesor.documento }}</td>
                <td>{{ profesor.nombres }}</td>
                <td>{{ profesor.telefono }}</td>
                <td>{{ profesor.email }}</td>
                <td>{{ profesor.direccion }}</td>
                <td>{{ profesor.ciudad }}</td>
                <td>
                  <div style="display: flex; gap: 0.5rem">
                    <span
                      class="link"
                      @click="
                        () => {
                          update = true;
                          register = false;
                          asignatura = false;
                          cargarProfesor(profesor);
                        }
                      "
                      >Editar</span
                    >
                    <span
                      class="link red"
                      @click="
                        () => {
                          update = false;
                          register = false;
                          asignatura = true;
                          cargarProfesor(profesor);
                          listarAsignaturasProfesor(profesor.id);
                        }
                      "
                      >Asignaturas</span
                    >
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div style="display: flex; justify-content: flex-end">
            <div class="pagination">
              <a
                href="#"
                v-for="link in links"
                :key="generateUUID(link)"
                :class="{ active: link.active }"
                @click="listarProfesores(link.url)"
                ><span v-html="link.label"></span
              ></a>
            </div>
          </div>
        </div>
      </section>
    </div>
    <Footer />
  </div>
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";
import Header from "@/components/AdminHeader.vue";
import Footer from "@/components/AdminFooter.vue";
import Title from "@/components/page/Title.vue";
import FormToggleSlider from '@/components/form/components/FormToggleSlider.vue';
export default {
  name: "Dashboard",
  components: {
    Header,
    Footer,
    Title,
    FormToggleSlider
  },

  data: function () {
    return {
      register: false,
      update: false,

      asignatura: false,
      id_asignatura: "",

      links: [],
      profesores: [],
      asignaturas: [],
      cursos: [],
      profesor: {
        id: "",
        documento: "123",
        nombres: "Alejandro",
        telefono: "313",
        email: "cubillosalejandro122@gmail.com",
        direccion: "Cra 16",
        ciudad: "Pitalito",
        password: "123",
        id_profesor: "",
      },
    };
  },

  methods: {
    onUpdateEstado({value, id}) {

      let data = {
        estado: value ? 'activo' : 'inactivo'
      }

      axios.post(`http://127.0.0.1:8000/api/profesor/course/${id}/update`, data,
      {
        headers: { Authorization: "Bearer " + localStorage.getItem("token") },
      })
      .then(() => {
        this.listarAsignaturasProfesor(this.profesor.id_profesor)
      })
    },

    isValidText(data) {
      var regex = new RegExp("^[a-zA-ZÀ-ÿ ]+$");
      var key = data;
      if (!regex.test(key)) return false;
      return true;
    },
    isValidEmail(email) {
      let re =
        /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i;
      if (re.test(email)) return true;
      else return false;
    },
    generateUUID() {
      var d = new Date().getTime();
      var uuid = "xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx".replace(
        /[xy]/g,
        function (c) {
          var r = (d + Math.random() * 16) % 16 | 0;
          d = Math.floor(d / 16);
          return (c == "x" ? r : (r & 0x3) | 0x8).toString(16);
        }
      );
      return uuid;
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

    listarProfesores(url) {
      if (!url) url = "http://127.0.0.1:8000/api/profesor";
      axios
        .get(url, {
          headers: { Authorization: "Bearer " + localStorage.getItem("token") },
        })
        .then(({ data }) => {
          this.links = data.links;
          this.profesores = data.data;
        })
        .catch((e) => console.log(e.response));
    },

    listarAsignaturas() {
      axios
        .get("http://127.0.0.1:8000/api/asignatura", {
          headers: { Authorization: "Bearer " + localStorage.getItem("token") },
        })
        .then(({ data }) => {
          this.id_asignatura = data.data[0].id;
          this.asignaturas = data.data;
        })
        .catch((e) => {
          console.log(e.response);
        });
    },
    listarAsignaturasProfesor(id) {
      axios
        .get(`http://127.0.0.1:8000/api/profesor/${id}/courses`, {
          headers: { Authorization: "Bearer " + localStorage.getItem("token") },
        })
        .then(({ data }) => {
          this.cursos = data;
        })
        .catch((e) => console.log(e.response));
    },

    cargarProfesor(data) {
      this.profesor.id = data.id_user;
      this.profesor.documento = data.documento;
      this.profesor.nombres = data.nombres;
      this.profesor.telefono = data.telefono;
      this.profesor.email = data.email;
      this.profesor.direccion = data.direccion;
      this.profesor.ciudad = data.ciudad;
      this.profesor.password = data.password;
      this.profesor.id_profesor = data.id;
    },

    limpiarFormulario() {
      this.update = false;
      this.profesor.id = "";
      this.profesor.documento = "";
      this.profesor.nombres = "";
      this.profesor.telefono = "";
      this.profesor.email = "";
      this.profesor.direccion = "";
      this.profesor.ciudad = "";
      this.profesor.password = "";
      this.profesor.id_profesor = "";
    },

    async registrarProfesor(data) {
      if (!this.isValidText(data.nombres))
        return this.launchAlert({
          type: "warning",
          title: "¡El nombre no puede contener carácteres especiales!",
        });

      if (!this.isValidEmail(data.email))
        return this.launchAlert({
          type: "warning",
          title: "¡El correo no es válido!",
        });

      try {
        let user = await axios.post(
          "http://127.0.0.1:8000/api/user/register",
          data,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          }
        );

        axios
          .post(
            "http://127.0.0.1:8000/api/profesor/register",
            {
              id_user: user.data.data.id,
            },
            {
              headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
              },
            }
          )
          .then(() => {
            this.register = false;
            this.limpiarFormulario();
            this.listarProfesores();
            return this.launchAlert({
              type: "success",
              title: "¡Profesor registrado!",
            });
          })
          .catch((e) => {
            console.log(e.response);
          });
      } catch (error) {
        console.log(error.response);
      }
    },
    async actualizarProfesor(data) {
      if (!this.isValidText(data.nombres))
        return this.launchAlert({
          type: "warning",
          title: "¡El nombre no puede contener carácteres especiales!",
        });

      if (!this.isValidEmail(data.email))
        return this.launchAlert({
          type: "warning",
          title: "¡El correo no es válido!",
        });

      try {
        await axios.post(
          "http://127.0.0.1:8000/api/user/update/" + data.id,
          data,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          }
        );

        this.listarProfesores();
        this.limpiarFormulario();
        return this.launchAlert({
          type: "success",
          title: "¡Profesor actualizado!",
        });
      } catch (error) {
        console.log(error.response);
      }
    },
    async registrarAsignatura() {
      axios
        .post(
          "http://127.0.0.1:8000/api/profesor/course/assign",
          {
            id_profesor: this.profesor.id_profesor,
            id_asignatura: this.id_asignatura,
          },
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          }
        )
        .then(() => {
          this.id_asignatura = this.asignaturas[0].id;
          this.listarAsignaturasProfesor(this.profesor.id_profesor);
          return this.launchAlert({
            type: "success",
            title: "¡Materia asignada exitosamente!",
          });
        })
        .catch((e) => console.log(e.response));
    },
  },
  computed: {
    ...mapState(["sessionUser"]),
  },
  mounted() {
    this.listarProfesores();
    this.listarAsignaturas();
  },
};
</script>
<style scoped>
.row {
  display: flex;
  gap: 0.5rem;
  justify-content: space-between;
}
.row > .col {
  width: 100%;
  box-sizing: border-box;
}
.row > .col input,
.row > .col select {
  width: 100%;
  box-sizing: border-box;
  padding: 0.3rem 0.5rem;
  border: 0;
  box-shadow: 0 0 1px #000000;
  border-radius: 2px;
}
/* FORMULARIO */
.formulario-registro {
  margin: 0 auto;
  width: 95%;
  top: -3rem;
  padding: 2rem 1.5rem;
  padding-top: 4rem;
  max-width: 750px;
  box-shadow: inset 0 0 2px #818181, 0 0 5px #c9c9c9;
  border-radius: 1rem;
  position: absolute;
  background: #fff;
}
.formulario-registro .titulo {
  color: #fff;
  position: absolute;
  top: 1.5rem;
  left: -0.7rem;
  background: #0056a0;
  padding: 0.4rem 2.5rem;
  font-size: 1.2rem;
  text-transform: uppercase;
}
.formulario-registro .cross-btn {
  background: none;
  border: 0;
  font-size: 2rem;
  color: #818181;
  position: absolute;
  right: 1.5rem;
  top: 1.5rem;
  cursor: pointer;
}

/* BOTÓN */
.btn-confirm button {
  margin-top: 1rem;
  background: none;
  border: 0;
  text-transform: uppercase;
  font-size: 1.2rem;
  letter-spacing: 0.02rem;
  color: #4a4a4a;
  cursor: pointer;
}
.btn-confirm.primary button {
  padding: 0.3rem 0.5rem;
  border: dashed 2px #7f7f7f;
}

.row-asignatura {
  display: grid;
  grid-template-columns: 1fr 4rem 5rem;
  margin: 1rem 1.2rem;
  border-bottom: solid 1px #e4e4e4;
}

.span-activo {
  color: rgb(177, 3, 3);
}
.span-inactivo {
  color: rgb(9, 129, 9);
}
</style>