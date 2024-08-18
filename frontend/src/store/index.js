import { createStore } from 'vuex'
import { jwtDecode } from 'jwt-decode'

export default createStore({
  state: {
    user: null,
    token: null
  },
  getters: {

  },
  actions: {
    setSession({ commit, dispatch  }) {

      const token = localStorage.getItem('token')

      if (token) {

        commit('setToken', token)

        try {

          const decoded = jwtDecode(token)

          commit('setUser', decoded)

        } catch (error) {

          console.error('Error decodificando el token:', error)

          dispatch('logout')
        }
      }
    },
    logout({ commit }) {

      commit('setUser', null)

      commit('setToken', null)
    }
  },
  mutations: {
    setToken(state, token) {
    
      state.token = token

      if (token) {
        localStorage.setItem('token', token)
      } else {
        localStorage.removeItem('token')
      }
      
    },
    setUser(state, user) {

      state.user = user
    }
  },
  modules: {
  }
})
