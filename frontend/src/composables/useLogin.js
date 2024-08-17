export const useLogin = async (email, password) => {
  
    try {

        const data = await( await fetch(`${process.env.VUE_APP_DOMAIN}/api/auth/login`, {
            method: 'POST',
            body: JSON.stringify({ email, password }),
            headers: {
                'Content-Type': 'application/json',
            },
        })).json()

        if (data.error) throw 'Usuario o contraseña erroneos'

        return data

    } catch (e) {

        throw e
        
    }
}