export function useUrlValidation(url) {

  if (url.includes('http://') || url.includes('https://')) {
    throw new Error('No se permite "http://" en la URL.')
  }

  if (!url.startsWith('www.')) {
    throw new Error('La URL debe comenzar con "www."')
  }

  const domainPattern = /^www\.[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\/[a-zA-Z0-9-_\/]*)?$/
  if (!domainPattern.test(url)) {
    throw new Error('El dominio no es válido.')
  }

  return true

}
