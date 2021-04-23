<template>
  <div id="app">
    <div class="container mx-auto py-2">
      <div v-if="status_checked == 1 && Object.keys(user).length > 0">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-8">
            <div></div>
            <div>
              <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{ user.name }}'s Todo
                <span class="text-sm cursor-pointer bg-white hover:bg-blue-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow float-right" @click="this.logout">
                    Logout
                </span>
              </h2>
              <div class="mx-auto px-2">
                <todo-list :list="this.list" @create="create" @toggle="toggle" @remove="remove"/>
              </div>
            </div>
        </div>
      </div>
      <div v-else-if="status_checked == 1 && Object.keys(user).length == 0">
          <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate bg-gray-100 p-10">
              Login to Todo Portal
          </h2>
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-8">
            <div></div>
            <div><Login :status="this.status" @login="data => this.login(data)" /></div>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import TodoList from "./components/TodoList.vue";
import Login from "./components/Login.vue";
const axios = require('axios').default;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Authorization' : 'Bearer '+ localStorage.getItem('token')
};
const baseurl = 'http://127.0.0.1:8000/api/';

export default {
  name: "App",
  components: { TodoList, Login },
  mounted: function() {
        this.load();
        this.checkState();
  },
  methods: {
    create: function(data) {
      if (data === "") return;
      console.log(data);
      var post_data ={'title' : data};
      axios.post(baseurl+'todos', post_data)
            .then(res => {
                      console.log(res);
                      this.load();
                }).catch(err => {
                    console.log(err)
                });
    },
    toggle: function(id) {
        axios.patch(baseurl+'todos/'+id)
                .then(res => {
                    {  
                      console.log(res);
                      this.load();
                    }
                }).catch(err => {
                    console.log(err)
                });
    },
    remove: function(id) {
        axios.delete(baseurl+'todos/'+id)
                .then(res => {
                    {  
                      console.log(res);
                      this.load();
                    }
                }).catch(err => {
                    console.log(err)
                });
    },
    load :function() {
        axios.get(baseurl+'todos')
                .then(res => {
                    {  
                      this.list = res.data.data;
                    }
                }).catch(err => {
                    console.log(err)
                });
    },
    login : function(data) {
      this.status = 2;
        axios.post(baseurl+'login', data)
                .then(res => {
                    {
                      console.log(res);
                      console.log(res.data.data.token);
                      if(res.data.data.token !== '')
                      {
                        this.status = 1;
                        localStorage.setItem('token', res.data.data.token);
                        location.reload();
                        this.checkState();
                      }
                      console.log(res);
                    }
                }).catch(err => {
                  this.user = [];
                  this.status = -1;
                    console.log(err)
                });
    },
    logout : function() {
        axios.get(baseurl+'logout')
                .then(res => {
                    {
                        localStorage.setItem('token', '');
                        location.reload();
                        console.log(res);
                    }
                }).catch(err => {
                    console.log(err)
                });
    },
    checkState : function() {
      axios.get(baseurl+'user')
                .then(res => {
                    {  
                      this.status_checked = 1;
                      this.user = res.data.data;
                      console.log(res.data.data);
                    }
                }).catch(err => {
                  this.status_checked = 1;
                  this.user = [];
                    console.log(err)
                });
    }
  },
  data() {
    return {
      list: [],
      user: [],
      status : 0,
      status_checked: 0
    };
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 10px;
}
textarea:focus,
input:focus {
  outline: none;
}
</style>
