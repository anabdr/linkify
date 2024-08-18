<template>
  <div class="loading">
    <p>Cargando...</p>
  </div>
</template>


<style scoped lang="scss">
.loading {
  position: fixed;
  top:0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9;
  background-color: #ffffff94;
  display: flex;
  align-items:center;
  justify-content: center;
  
  p {
    font-weight: 600;
    font-size: 1.5rem;
  }
}
</style>
