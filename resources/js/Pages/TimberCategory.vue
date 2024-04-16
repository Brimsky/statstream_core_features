<template>
  <div>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="specie in species" :key="specie.id">
          <td>{{ specie.name }}</td>
          <td><InertiaLink :href="route('timber-chart.show', { id: specie.id })">View Details</InertiaLink></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    species: Array
  }
}
</script>
