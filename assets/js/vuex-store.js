const state = {
    ga_id: '123123',
    app_title: '',
};

const getters = {
    getGAID(state) {
        return state.ga_id;
    },
    getAppTitle(state) {
        return state.app_title;
    }
};

const mutations = {
    setGAID(state, ga_id) {
        state.ga_id = ga_id;
    },
    setAppTitle(state, title) {
        state.app_title = title;
    }
};

const actions = {
    updateGAID({ commit }, ga_id) {
        commit('setGAID', ga_id);
    },
    updateAppTitle({ commit }, title) {
        commit('setAppTitle', title);
    }
};

export default {
    modules: state,
    getters,
    mutations,
    actions,
    strict: true,
};