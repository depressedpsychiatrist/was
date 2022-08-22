import axios from "axios";

export default {
    initialize(context) {
        return new Promise((resolve, reject) => {
            axios
                .get('initialize')
                .then(({
                    data
                }) => {
                    context.commit('INITIALIZE', data)
                    resolve({})
                })
                .catch(error => {
                    reject(error)
                })
        })
    },
    signUp(context, data) {
        return new Promise((resolve, reject) => {
            axios.post('auth/register', data)
                .then(({
                    data
                }) => {
                    resolve(data)
                }).catch(error => {
                    reject(error)
                })
        })
    },
    login({
        commit
    }, credentials) {
        return new Promise((resolve, reject) => {
            axios
                .post(`auth/login`, credentials)
                .then(({
                    data
                }) => {
                    commit("LOGIN", data);
                    resolve(data);
                })
                .catch((err) => {
                    reject(err);
                });
        });
    },
    logout({
        commit
    }) {
        return new Promise((resolve, reject) => {
            axios
                .get(`auth/logout`)
                .then((result) => {
                    commit("LOGOUT");
                    resolve(result);
                })
                .catch((err) => {
                    console.log(err);
                    reject(err);
                });
        });
    },

};
