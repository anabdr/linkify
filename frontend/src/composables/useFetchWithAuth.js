import { useRouter } from 'vue-router'

export async function useFetchWithAuth(url, options = {}, store = null) {

    const router = useRouter()

    try {

        const response = await fetch(url, options)

        if (response.status === 401) {
            
            if (store) store.dispatch('logout')

            if (router) await router.push({ name: 'Login' })

            return null
        }
    
        const data = await response.json()

        return data

    } catch (error) {

      throw error

    }

}
