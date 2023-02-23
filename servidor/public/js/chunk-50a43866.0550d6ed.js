(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-50a43866"],{bfe8:function(t,e,i){"use strict";i("d473")},d473:function(t,e,i){},dd4e:function(t,e,i){"use strict";i.r(e);var s=function(){var t=this,e=t._self._c;return e("div",[e("Header"),e("div",{staticClass:"admin-container"},[e("section",{staticClass:"body-info-section"},[e("div",{staticClass:"content-section-info"},[e("Title",{attrs:{title:"Estudiantes"}}),e("div",{staticClass:"btn-confirm primary",staticStyle:{display:"flex","justify-content":"flex-end"}},[t.register||t.update?t._e():e("button",{on:{click:()=>{t.register=!0,t.limpiarFormulario()}}},[t._v("Nuevo registro")])]),e("div",{staticStyle:{display:"flex","justify-content":"center"}},[t.register||t.update?e("div",{staticClass:"formulario-registro"},[!1===t.update?e("p",{staticClass:"titulo"},[t._v("Registro de estudiante")]):e("p",{staticClass:"titulo"},[t._v("Actualizar estudiante")]),e("button",{staticClass:"cross-btn",on:{click:()=>{t.register=!1,t.limpiarFormulario()}}},[t._v("×")]),e("div",{staticClass:"row"},[e("div",{staticClass:"col"},[e("p",[t._v("Documento")]),e("input",{directives:[{name:"model",rawName:"v-model",value:t.estudiante.documento,expression:"estudiante.documento"}],attrs:{type:"number"},domProps:{value:t.estudiante.documento},on:{input:function(e){e.target.composing||t.$set(t.estudiante,"documento",e.target.value)}}})]),e("div",{staticClass:"col"},[e("p",[t._v("Nombres")]),e("input",{directives:[{name:"model",rawName:"v-model",value:t.estudiante.nombres,expression:"estudiante.nombres"}],attrs:{type:"text"},domProps:{value:t.estudiante.nombres},on:{input:function(e){e.target.composing||t.$set(t.estudiante,"nombres",e.target.value)}}})]),e("div",{staticClass:"col"},[e("p",[t._v("Teléfono")]),e("input",{directives:[{name:"model",rawName:"v-model",value:t.estudiante.telefono,expression:"estudiante.telefono"}],attrs:{type:"text"},domProps:{value:t.estudiante.telefono},on:{input:function(e){e.target.composing||t.$set(t.estudiante,"telefono",e.target.value)}}})])]),e("div",{staticClass:"row"},[e("div",{staticClass:"col"},[e("p",[t._v("Dirección")]),e("input",{directives:[{name:"model",rawName:"v-model",value:t.estudiante.direccion,expression:"estudiante.direccion"}],attrs:{type:"text"},domProps:{value:t.estudiante.direccion},on:{input:function(e){e.target.composing||t.$set(t.estudiante,"direccion",e.target.value)}}})]),e("div",{staticClass:"col"},[e("p",[t._v("Ciudad")]),e("input",{directives:[{name:"model",rawName:"v-model",value:t.estudiante.ciudad,expression:"estudiante.ciudad"}],attrs:{type:"text"},domProps:{value:t.estudiante.ciudad},on:{input:function(e){e.target.composing||t.$set(t.estudiante,"ciudad",e.target.value)}}})]),e("div",{staticClass:"col"},[e("p",[t._v("Semestre")]),e("input",{directives:[{name:"model",rawName:"v-model",value:t.estudiante.semestre,expression:"estudiante.semestre"}],attrs:{type:"number"},domProps:{value:t.estudiante.semestre},on:{input:function(e){e.target.composing||t.$set(t.estudiante,"semestre",e.target.value)}}})])]),e("div",{staticClass:"row"},[e("div",{staticClass:"col"},[e("p",[t._v("Email")]),e("input",{directives:[{name:"model",rawName:"v-model",value:t.estudiante.email,expression:"estudiante.email"}],attrs:{type:"text"},domProps:{value:t.estudiante.email},on:{input:function(e){e.target.composing||t.$set(t.estudiante,"email",e.target.value)}}})]),!1===t.update?e("div",{staticClass:"col"},[e("p",[t._v("Contraseña")]),e("input",{directives:[{name:"model",rawName:"v-model",value:t.estudiante.password,expression:"estudiante.password"}],attrs:{type:"number"},domProps:{value:t.estudiante.password},on:{input:function(e){e.target.composing||t.$set(t.estudiante,"password",e.target.value)}}})]):t._e()]),!1===t.update?e("div",{staticClass:"btn-confirm"},[e("button",{on:{click:function(e){return t.registrarEstudiante(t.estudiante)}}},[t._v(" Registrar ")])]):e("div",{staticClass:"btn-confirm"},[e("button",{on:{click:function(e){return t.actualizarEstudiante(t.estudiante)}}},[t._v(" Guardar ")])])]):t._e()]),e("table",{staticClass:"styled-table"},[t._m(0),e("tbody",t._l(t.estudiantes,(function(i){return e("tr",{key:i.id},[e("td",[t._v(t._s(i.documento))]),e("td",[t._v(t._s(i.nombres))]),e("td",[t._v(t._s(i.telefono))]),e("td",[t._v(t._s(i.email))]),e("td",[t._v(t._s(i.direccion))]),e("td",[t._v(t._s(i.ciudad))]),e("td",[t._v(t._s(i.semestre))]),e("td",[e("span",{staticClass:"link",on:{click:function(e){return t.cargarEstudiante(i)}}},[t._v("Editar")])])])})),0)]),e("div",{staticStyle:{display:"flex","justify-content":"flex-end"}},[e("div",{staticClass:"pagination"},t._l(t.links,(function(i){return e("a",{key:t.generateUUID(i),class:{active:i.active},attrs:{href:"#"},on:{click:function(e){return t.listarEstudiantes(i.url)}}},[e("span",{domProps:{innerHTML:t._s(i.label)}})])})),0)])],1)])]),e("Footer")],1)},a=[function(){var t=this,e=t._self._c;return e("thead",[e("tr",[e("td",[t._v("Documento")]),e("td",[t._v("Nombres")]),e("td",[t._v("Teléfono")]),e("td",[t._v("Email")]),e("td",[t._v("Dirección")]),e("td",[t._v("Ciudad")]),e("td",[t._v("Semestre")]),e("td",[t._v("Acción")])])])}],n=i("5407"),o=i("dc36"),r=i("5619"),d=i("2f62"),u=i("bc3a"),l=i.n(u),c={name:"Dashboard",components:{Header:n["a"],Footer:o["a"],Title:r["a"]},data:function(){return{register:!1,update:!1,links:[],estudiantes:[],estudiante:{id:"",documento:"",nombres:"",telefono:"",email:"",direccion:"",ciudad:"",semestre:"",password:"",id_estudiante:""}}},methods:{isValidText(t){var e=new RegExp("^[a-zA-ZÀ-ÿ ]+$"),i=t;return!!e.test(i)},isValidEmail(t){let e=/^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i;return!!e.test(t)},generateUUID(){var t=(new Date).getTime(),e="xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx".replace(/[xy]/g,(function(e){var i=(t+16*Math.random())%16|0;return t=Math.floor(t/16),("x"==e?i:3&i|8).toString(16)}));return e},launchAlert(t){t.timeout||(t.timeout=2500);const e=this.$swal.mixin({toast:!0,position:"top-end",showConfirmButton:!1,timer:t.timeout});e.fire({icon:t.type,title:t.title,text:t.message})},listarEstudiantes(t){t||(t="http://127.0.0.1:8000/api/estudiante"),l.a.get(t,{headers:{Authorization:"Bearer "+localStorage.getItem("token")}}).then(({data:t})=>{this.links=t.links,this.estudiantes=t.data}).catch(t=>{console.log(t.response)})},cargarEstudiante(t){this.update=!0,this.register=!1,this.estudiante.id=t.id_user,this.estudiante.documento=t.documento,this.estudiante.nombres=t.nombres,this.estudiante.telefono=t.telefono,this.estudiante.email=t.email,this.estudiante.direccion=t.direccion,this.estudiante.ciudad=t.ciudad,this.estudiante.semestre=t.semestre,this.estudiante.password=t.password,this.estudiante.id_estudiante=t.id},limpiarFormulario(){this.update=!1,this.estudiante.id="",this.estudiante.documento="",this.estudiante.nombres="",this.estudiante.telefono="",this.estudiante.email="",this.estudiante.direccion="",this.estudiante.ciudad="",this.estudiante.semestre="",this.estudiante.password="",this.estudiante.id_estudiante=""},async registrarEstudiante(t){if(!this.isValidText(t.nombres))return this.launchAlert({type:"warning",title:"¡El nombre no puede contener carácteres especiales!"});if(!this.isValidEmail(t.email))return this.launchAlert({type:"warning",title:"¡El correo no es válido!"});try{let e=await l.a.post("http://127.0.0.1:8000/api/user/register",t,{headers:{Authorization:"Bearer "+localStorage.getItem("token")}});l.a.post("http://127.0.0.1:8000/api/estudiante/register",{id_user:e.data.data.id,semestre:t.semestre},{headers:{Authorization:"Bearer "+localStorage.getItem("token")}}).then(()=>(this.register=!1,this.limpiarFormulario(),this.listarEstudiantes(),this.launchAlert({type:"success",title:"¡Estudiante registrado!"}))).catch(t=>{console.log(t.response)})}catch(e){console.log(e.response)}},async actualizarEstudiante(t){if(!this.isValidText(t.nombres))return this.launchAlert({type:"warning",title:"¡El nombre no puede contener carácteres especiales!"});if(!this.isValidEmail(t.email))return this.launchAlert({type:"warning",title:"¡El correo no es válido!"});try{return await l.a.post("http://127.0.0.1:8000/api/user/update/"+t.id,t,{headers:{Authorization:"Bearer "+localStorage.getItem("token")}}),await l.a.post("http://127.0.0.1:8000/api/estudiante/update/"+t.id_estudiante,{semestre:t.semestre},{headers:{Authorization:"Bearer "+localStorage.getItem("token")}}),this.listarEstudiantes(),this.limpiarFormulario(),this.launchAlert({type:"success",title:"¡Estudiante actualizado!"})}catch(e){console.log(e.response)}}},computed:{...Object(d["d"])(["sessionUser"])},mounted(){this.listarEstudiantes()}},m=c,p=(i("bfe8"),i("0c7c")),v=Object(p["a"])(m,s,a,!1,null,"b476f800",null);e["default"]=v.exports}}]);
//# sourceMappingURL=chunk-50a43866.0550d6ed.js.map