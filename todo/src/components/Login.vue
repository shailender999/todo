<template>
  <div>
    <div class="new-item px-2 py-4">
        <form @submit="login">
            <div class="relative w-full mb-3">
                <input type="email" v-model="input.email" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" placeholder="Email">
            </div>
            <div class="relative w-full mb-3">
                <input type="password" v-model="input.password" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" placeholder="Password">
            </div>
            <div v-if="status == -1" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Invalid Email/Password</strong>
            </div>
            <div v-else-if="status == 1" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Login Successfull!!</strong>
            </div>
            <div v-else-if="status == 2" class="bg-silver-100 border border-silver-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Please wait !!</strong>
            </div>
            <div class="text-center mt-6">
                <button v-on:click="login()" class="bg-blueGray-800 text-blue active:bg-blueGray-600 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150" type="button">Sign In</button>
            </div>
        </form>
    </div>
  </div>
</template>
<script>
export default {
   name: 'Login',
   props: {
       status : {
           default: () => 0
       }
   },
   data() {
       return {
           input: {
               email : "",
               password: ""
           }
       }
   },
   methods: {
       login() {
           if (this.input.email != "" && this.input.password != "") {
                var post_data ={
                                'email' : this.input.email,
                                'password' : this.input.password
                            };
                console.log(post_data);
                this.$emit('login', post_data);
           }
       }
   }
};
</script>
