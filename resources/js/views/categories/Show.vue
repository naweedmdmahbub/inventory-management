<template>
  <div class="app-container">
    <el-dialog
      :title="formTitle"
      :visible.sync="dialogFormVisible"
    >
      <form-component
        v-if="isMounted"
        :category="category"
        mode="show"
        @dismissDialog="dismissDialog"
      />
    </el-dialog>
  </div>
</template>

<script>
import FormComponent from './FormComponent';
export default {
  components: { FormComponent },
  props: ['category'],
  data() {
    return {
      loading: true,
      downloading: false,
      formTitle: 'View Category',
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