<template>
  <div class="home mt-5">
    <div class="alert alert-success" role="alert" v-if="success">
      {{ success }}
    </div>
    <div class="alert alert-danger" role="alert" v-if="error">
      {{ error }}
    </div>
    <h2 v-if="!user">Welcome, please log in or register</h2>
    <h2 v-else-if="!user.email_verified_at">
      Hello, {{ user.name }}! Registration successful {{token}}
    </h2>
    <h2 v-else>Hello, {{ user.name }}! You're in.</h2>

    <div v-if="user">
      <div class="row mt-3">
        <div class="col-md-2">
          <label>API token : </label>
        </div>
        <div class="col-md-6">
         <input type="text" class="form-control" v-model="userToken" readonly>
        </div>
        <div class="col-md-4">
          <button class="btn btn-primary" @click="generateNewToken">Generate</button>
        </div>
      </div>
      
      
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";

export default {
  name: "Home",

  data() {
    return {
      success: null,
      error: null,
    };
  },

  computed: {
    ...mapState("auth",[
        'userToken',
    ]),

    ...mapGetters("auth", ["user"], ["token"]),
    ...mapActions("auth", ["getUserToken"]),
  },
  mounted(){
    if(typeof this.user !== 'undefined' && this.user){
        this.getUserToken();
    }

  },

  methods: {
    ...mapActions("auth",["generateUserToken"]),
    generateNewToken(){
        this.generateUserToken(this.user.id);
    }

  }
};
</script>
