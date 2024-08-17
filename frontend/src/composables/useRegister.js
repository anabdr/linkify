export const useRegister = async (email, password, name) => {
  
    try {

        const data = await( await fetch(`${process.env.VUE_APP_DOMAIN}/api/auth/register`, {
            method: 'POST',
            body: JSON.stringify({ email, password, name }),
            headers: {
                'Content-Type': 'application/json',
            },
        })).json()

        if (data.error) throw 'Ha ocurrido un error'

        return data

    } catch (e) {

        throw e
                
    }
}