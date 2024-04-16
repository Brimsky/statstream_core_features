<template>
  <div>
    <h1>{{ specie.species }}</h1>
    <p>Type: {{ specie.type }}</p>
    <p>Description: {{ specie.class }}</p> <!-- Note: Is 'class' the right field? -->
  </div>
</template>

<script>
export default {
  props: {
    specie: Object
  },
  mounted() {
    console.log(this.specie); // This will help you see what you're actually getting from the backend
  }
}
</script>
