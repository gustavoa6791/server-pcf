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
    createSlotType({ commit }, st) {
        return axios.post('/api/slotType', st)
            .then(res => {
                commit('CREATE_SLOT_TYPE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
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


    fetchService({ commit }) {
        return axios.get('/api/service')
            .then(res => {
                return res.data
            }).catch(err => {
                console.log(err)
            })
    },
    updateService({ commit },services) {
        return axios.put(`/api/service/${services[0]}`, {services:services[1]})
            .then(res => {
                commit('UPDATE_SERVICE', res.data)
            }).catch(err => {
                console.log(err)
            })
    },
    deleteService({ commit }, sv) {
        axios.delete(`/api/service/${sv.id}`)
            .then(res => {
                if (res.data === 'delete'){
                    commit('DELETE_SERVICE', sv)
                }
            }).catch(err => {
                console.log(err)
            })
    },


    createAttentionType({ commit }, st) {
        return axios.post('/api/attentionType', st)
            .then(res => {
                commit('CREATE_ATTENTION_TYPE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
            })
    },
    findAttentionType({ commit } , st) {
        return axios.get(`/api/attentionType/${st}`)
            .then(res => {
                commit('FIND_ATTENTION_TYPE', res.data)
                return res.data
            }).catch(err => {
                console.log(err)
            })
    },
    deleteAttentionType({ commit }, at) {
        axios.delete(`/api/attentionType/${at.id}`)
            .then(res => {
                if (res.data === 'delete'){
                    commit('DELETE_ATTENTION_TYPE', at)
                }
            }).catch(err => {
                console.log(err)
            })
    }, 
    editAttentionType({ commit }, st) {
        return axios.put(`/api/attentionType/${st.id}`, st)
            .then(res => {
                commit('EDIT_ATTENTION_TYPE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
            })
    },

    fetchPlanAsegurador({ commit }) {
        return axios.get('/api/plan')
            .then(res => {
                return res.data
            }).catch(err => {
                console.log(err)
            })
    },

    fetchTemplate({ commit }) {
        return axios.get('/api/template')
            .then(res => {
                return res.data
            }).catch(err => {
                console.log(err)
            })
    },

    fetchOrgStructure({ commit }) {
        axios.get('/api/orgStructure')
            .then(res => {
                commit('FETCH_ORG_STRUCTURE', res.data)
            }).catch(err => {
                console.log(err)
            })
    },
    createOrgStructure({ commit }, os) {
        return axios.post('/api/orgStructure', os)
            .then(res => {
                commit('CREATE_ORG_STRUCTURE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
            })
    },
    editOrgStructure({ commit }, os) {
        return axios.put(`/api/orgStructure/${os.id}`, os)
            .then(res => {
                commit('EDIT_ORG_STRUCTURE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
            })
    },


}

export default actions