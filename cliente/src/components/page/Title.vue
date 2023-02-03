<template>
    <div>
        <img class="long-image" src="@/assets/img/resources/longImage.jpg" alt="">
        <div class="title-dash">
            <h1 class="title-text">{{ capitalizeFirstLetter(title) }}</h1>
            <ul class="breadcrumb" v-if="title">
                <li v-for="(route, index) in routes" :key="index">
                    <router-link :to="'/' + route.route" v-if="(index+1) != routes.length">
                        {{route.name}}
                    </router-link>
                    <span v-else>{{route.name}}</span>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default{
    name: "titleComponent",
    data() {
        return {
            routes: []
        }
    },
    props: {
        title: [String],
    },
    methods: {
        capitalizeFirstLetter(str) {return str.charAt(0).toUpperCase() + str.slice(1)}
    },
    mounted(){
        var route = this.$route.path;
        let newPlace = '';
        route.split('/').forEach(place => {
            if(place == 'activity') return
            if(!place) {
                newPlace = {route: 'dashboard', name: 'Home'}
            }
            else newPlace = {route: place, name: this.capitalizeFirstLetter(place)}
            if(!parseInt(newPlace.route))  this.routes.push(newPlace)
        });
    }
}
</script>
<style>
.long-image {
    display: block;
    width: 100%;
    max-width: 1480px;
    margin: 0 auto;
}
.title-dash {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
    margin: 5px 0 10px 0;
}
ul.breadcrumb {
    display: flex;
    justify-content: flex-end;
    float: right;
    padding: 10px 16px;
    list-style: none;
}

ul.breadcrumb li {
  display: inline;
  font-size: 18px;
}

/* Add a slash symbol (/) before/behind each list item */
ul.breadcrumb li+li:before {
    align-items: center;
    padding-left: 4px;
    color: black;
    content: "/\00a0";
}

/* Add a color to all links inside the list */
ul.breadcrumb li a {
  color: #0275d8;
  text-decoration: none;
}

/* Add a color on mouse-over */
ul.breadcrumb li a:hover {
  color: #01447e;
  text-decoration: underline;
}
</style>