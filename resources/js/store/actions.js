let actions = {
    fetchProfileType({ commit }) {
        axios.get('/api/profileType')
            .then(res => {
                commit('FETCH_PROFILE_TYPE', res.data)
            }).catch(err => {
                console.log(err)
            })
    },
    createProfileType({ commit }, pt) {
        return axios.post('/api/profileType', pt)
            .then(res => {
                commit('CREATE_PROFILE_TYPE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
            })
    },
    editProfileType({ commit }, pt) {
        return axios.put(`/api/profileType/${pt.id}`, pt)
            .then(res => {
                commit('EDIT_PROFILE_TYPE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
            })
    },

    deleteProfileType({ commit }, pt) {
       return axios.delete(`/api/profileType/${pt.id}`)
            .then(res => {
                if (res.data === 'delete'){
                    commit('DELETE_PROFILE_TYPE', pt)
                }
                return res.data
            }).catch(err => {
                console.log(err)
            })
    },

    deleteVerifyProfileType({ commit }, pt) {
        return axios.delete(`/api/profileType/verify/${pt.id}`)
             .then(res => {
                 return res.data
             }).catch(err => {
                 console.log(err)
             })
     },


     fetchSlotType({ commit }) {
        axios.get('/api/slotType')
            .then(res => {
                commit('FETCH_SLOT_TYPE', res.data)
            }).catch(err => {
                console.log(err)
            })
    },
    findSlotType({ commit } , st) {
        return axios.get(`/api/slotType/${st}`)
            .then(res => {
                commit('FIND_SLOT_TYPE', res.data)
                return res.data
            }).catch(err => {
                console.log(err)
            })
    }, 
    createSlotType({ commit }, st) {
        return axios.post('/api/slotType', st)
            .then(res => {
                commit('CREATE_SLOT_TYPE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
            })
    },
    editSlotType({ commit }, st) {
        return axios.put(`/api/slotType/${st.id}`, st)
            .then(res => {
                commit('EDIT_SLOT_TYPE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
            })
    },

    deleteSlotType({ commit }, st) {
       return axios.delete(`/api/slotType/${st.id}`)
            .then(res => {
                if (res.data === 'delete'){
                    commit('DELETE_SLOT_TYPE', st)
                }
                return res.data
            }).catch(err => {
                console.log(err)
            })
    },

    deleteVerifySlotType({ commit }, st) {
        return axios.delete(`/api/slotType/verify/${st.id}`)
             .then(res => {
                 return res.data
             }).catch(err => {
                 console.log(err)
             })
     },
}

export default actions