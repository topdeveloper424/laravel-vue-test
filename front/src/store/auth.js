import axios from "axios";

export default {
  namespaced: true,

  state: {
    userData: null,
    userToken: null
  },

  getters: {
    user: state => state.userData,
    token: state => state.userToken
  },

  mutations: {
    setUserData(state, user) {
      state.userData = user;
    },
    setUserToken(state, token) {
      state.userToken = token;
    }

  },

  actions: {
    getUserData({ commit }) {
      axios
        .get(process.env.VUE_APP_API_URL + "user")
        .then(response => {
          commit("setUserData", response.data);
        })
        .catch(() => {
          localStorage.removeItem("authToken");
        });
    },
    sendLoginRequest({ commit }, data) {
      commit("setErrors", {}, { root: true });
      return axios
        .post(process.env.VUE_APP_API_URL + "login", data)
        .then(response => {
          commit("setUserData", response.data.user);
          localStorage.setItem("authToken", response.data.token);
        });
    },
    sendRegisterRequest({ commit }, data) {
      commit("setErrors", {}, { root: true });
      return axios
        .post(process.env.VUE_APP_API_URL + "register", data)
        .then(response => {
          commit("setUserData", response.data.user);
          localStorage.setItem("authToken", response.data.token);
        });
    },
    sendLogoutRequest({ commit }) {
      axios.post(process.env.VUE_APP_API_URL + "logout").then(() => {
        commit("setUserData", null);
        localStorage.removeItem("authToken");
      });
    },
    getUserToken({ commit }, data) {
      return axios
        .get(process.env.VUE_APP_API_URL + "token/"+data.user.id)
        .then(response => {
          console.log(response.data);
          if(response.data.status !== "error"){
            commit("setUserToken", response.data.api_token);

          }
        })
    },
    generateUserToken({ commit }, data) {
      return axios
        .post(process.env.VUE_APP_API_URL + "token",{id:data})
        .then(response => {
          console.log(response.data);
          if(response.data.status !== "error"){
            commit("setUserToken", response.data.api_token);
          }
        })
    },

  }
};
