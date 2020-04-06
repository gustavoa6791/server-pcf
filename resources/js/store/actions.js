let actions = {
    createProfileType({ commit }, pt) {
        return axios.post('/api', pt)
            .then(res => {
                commit('CREATE_PROFILE_TYPE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
            })
    },
    editProfileType({ commit }, pt) {
        return axios.put(`/api/${pt.id}`, pt)
            .then(res => {
                commit('EDIT_PROFILE_TYPE', res.data)
            }).catch(err => {
                console.log(err)
                return err.response.data.errors
            })
    },
    searchProfileType({ commit }, ta, sl) {
        axios.get(`/api/${ta}/${sl}`)
            .then(res => {
                commit('SEARCH_PROFILE_TYPE', res.data)
            }).catch(err => {
                console.log(err)
            })
    },
    fetchProfileType({ commit }) {
        axios.get('/api')
            .then(res => {
                commit('FETCH_PROFILE_TYPE', res.data)
            }).catch(err => {
                console.log(err)
            })
    },
    deleteProfileType({ commit }, pt) {

        axios.delete(`/api/${pt.id}`)
            .then(res => {
                if (res.data === 'delete')
                    commit('DELETE_PROFILE_TYPE', pt)
            }).catch(err => {
                console.log(err)
            })
    }
}

export default actions