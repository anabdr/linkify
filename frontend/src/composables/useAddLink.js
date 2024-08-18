import { computed } from 'vue'
import { useFetchWithAuth } from '@/composables/useFetchWithAuth'

export const useAddLink = async (url, store) => {

    const token = computed(() => store.state.token)
    
    try {

        const data = await useFetchWithAuth(`${process.env.VUE_APP_DOMAIN}/api/auth/add`, {
            method: 'POST',
            body: JSON.stringify({ url }),
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token.value}`
            },
        },
        store)       

        if (data.error) throw 'Ha ocurrido un error'

        return data

    } catch (e) {

        throw e
        
    }
}