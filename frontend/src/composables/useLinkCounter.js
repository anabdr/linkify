import { computed } from 'vue'

export const useLinkCounter = async (store) => {

    const token = computed(() => store.state.token)
    
    try {

        const data = await( await fetch(`${process.env.VUE_APP_DOMAIN}/api/auth/all`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token.value}`
            },
        })).json()

        if (data.error) throw 'Ha ocurrido un error'

        return data

    } catch (e) {

        throw e
        
    }
}