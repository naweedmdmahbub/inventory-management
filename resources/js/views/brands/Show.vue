<template>
  <div class="app-container">
    <el-dialog
      :title="formTitle"
      :visible.sync="dialogFormVisible"
    >
      <form-component
        v-if="isMounted"
        :brand="brand"
        mood="show"
        @dismissDialog="dismissDialog"
      />
    </el-dialog>
  </div>
</template>

<script>
import FormComponent from './FormComponent';
export default {
  components: { FormComponent },
  props: ['brand'],
  data() {
    return {
      loading: true,
      downloading: false,
      formTitle: 'View Brand',
      dialogFormVisible: false,
      isMounted: false,
    };
  },
  watch: {
    dialogFormVisible(val){
      this.isMounted = val;
    }
  },
  methods: {
    dismissDialog(){
      this.dialogFormVisible = false;
    },
    handleShowModal(){
      this.dialogFormVisible = true;
    }
  }
}
</script>