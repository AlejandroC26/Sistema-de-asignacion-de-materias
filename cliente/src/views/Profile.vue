<template>
    <div>
        <Header/>
        <div class="admin-container">
            <section class="body-info-section">
                <div class="content-section-info">
                    <Title :title="'Perfíl de Usuario'"/>   
                    <div class="border-box" style="padding: 0;">
                        <div class="title-info-row">
                            <h2>Información Personal</h2>
                        </div>
                        <div class="row-info-box cursor-none">
                            <div class="first-column">NOMBRE</div>
                            <div class="last-column">{{sessionUser.name}}</div>
                        </div>
                        <div class="row-info-box">
                            <div class="first-column">ROL</div>
                            <div class="last-column">{{capitalizeString(sessionUser.rol)}}  </div>
                        </div>
                        <div class="row-info-box">
                            <div class="first-column">CORREO</div>
                            <div class="last-column">{{sessionUser.email}} </div>
                        </div>
                        <div class="row-info-box">
                            <div class="first-column">CONTRASEÑA</div>
                            <div class="last-column">************</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <Footer/>
    </div>
</template>
<script>
import Header from '@/components/AdminHeader.vue'
import Footer from '@/components/AdminFooter.vue'
import Title from '@/components/page/Title.vue'
import {mapMutations, mapActions, mapState} from 'vuex'

export default {
    name: 'Profile',
    components: {
        Header,
        Footer,
        Title
    },
    data: function () {
        return {
           
        }
    },
    methods: {
        capitalizeString(string) { 
          return string[0].toUpperCase() + string.slice(1); 
        } 
    },
    computed: {
        ...mapState(['sessionUser']),
    },
    mounted(){
    }
}
</script>
<style scoped>
.title-info-row{padding: 1.3rem 1rem .7rem 1rem;}
.title-info-row h2 {
    font-weight: 100;
    font-size: 1.2rem;
    color: #7a7a7a;
}

.row-info-box.cursor-none{
    cursor: pointer;
}
.title-info-box,
.box-info-row {
    color: #585858;
}
.row-info-box {
    cursor: pointer;
    display: flex;
    padding: 1.2rem 1rem;
    border-bottom: 1px solid var(--light-gray-color);
}
.row-info-box:hover {
    background-color: #f8f8f8;
}
.row-info-box:last-child{
    border-bottom: 0;
}
.row-info-box .first-column{
    display: flex;
    align-items: center;
    width: 15%;
    font-size: .8rem;
    letter-spacing: .05rem;
}
.row-info-box .last-column{
    font-size: 1em;
}



.wrapper-form-data .input-data input.wrong-email{
    border-bottom: 2px solid var(--title-clr);
}
.wrapper-form-data{margin: 5px 0;}
.border-box{padding: 1.5rem 1.8rem}
.row-box{
    display: grid;
    gap: 10px;
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 25rem), 1fr));
}
.row {
    border-bottom: solid 1px rgb(180, 180, 180);
    display: grid;
    grid-gap: 2px;
    grid-template-columns: 40px 1fr 1fr 100px 100px 150px;
}
select.form-control {
    padding: 5px;
    border-radius: 2px;
    outline: none;
    border: solid 2px rgb(180, 180, 180);
}
</style>