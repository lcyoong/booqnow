<template>
  <div>
    <autocomplete
      url="https://maps.googleapis.com/maps/api/geocode/json?address="
      :custom-params="{ token: 'dev' }"
      anchor="formatted_address"
      label="formatted_address"
      :process="processJSON"
      :on-select="getData" >
    </autocomplete>
  </div>
</template>

<script>

  import Autocomplete from 'vue2-autocomplete-js';

  export default {

    components: { Autocomplete },

    methods: {
      processJSON(json) {
        return json.results;
      },
      getData(data) {
        console.log(data);
      }
    }
  };

</script>
