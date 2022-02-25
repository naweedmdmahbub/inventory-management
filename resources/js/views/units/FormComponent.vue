<template>
  <div class="app-container">
      <div class="form-container">
        <el-form ref="unitForm" :model="unit" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item label="Name" prop="name">
            <el-input v-model="unit.name" />
          </el-form-item>
          <el-form-item label="Code" prop="code">
            <el-input v-model="unit.code" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="unitFormVisible = false">
            Cancel
          </el-button>
          <el-button type="primary" @click="handleSubmit">
            Confirm
          </el-button>
        </div>
      </div>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import FormComponent from './FormComponent';
export default {
  props: ['mood', 'unit'],
  data() {
    return {
      loading: true,
      downloading: false,
      unitFormVisible: false,
    };
  },
  methods: {
    dismissDialog() {
        this.$emit("dismissDialog")
    },
    handleSubmit() {
      // this.errors_exist = false;
      this.errors = [];
      var offset = 0;
      if (this.unit.id !== undefined) {
        axios
          .put('api/units/'+this.unit.id, this.unit)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Unit info has been updated successfully',
              duration: 5 * 1000,
            });
            this.dismissDialog();
            // this.getList();
          })
          .catch(error => {
            this.errors = error.response.data.errors;
            Object.entries(this.errors).forEach(([key, value]) => {
              this.$notify.error({
                title: 'Error',
                message: value[0],
                offset: offset,
              });
              offset += 60;
            });
            // this.getList();
          })
          .finally(() => {
            this.unitFormVisible = false;
          });
      } else {
        axios
          .post('api/units', this.unit)
          .then(response => {
            this.$message({
              message: 'New unit ' + this.unit.name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.unit = {
              name: '',
              code: '',
              description: '',
            };
            this.unitFormVisible = false;
            this.getList();
          })
          .catch(error => {
            // this.errors_exist = true;
            this.errors = error.response.data.errors;
            var offset = 0;
            Object.entries(this.errors).forEach(([key, value]) => {
              // console.log('entries: ',key, value, value[0]);
              this.$notify.error({
                title: 'Error',
                message: value[0],
                offset: offset,
              });
              offset += 60;
            });
            // console.log('Error:', this.errors);
          });
        
        
        // unitResource
        //   .store(this.unit)
        //   .then(response => {
        //     this.$message({
        //       message: 'New unit ' + this.unit.name + ' has been created successfully.',
        //       type: 'success',
        //       duration: 5 * 1000,
        //     });
        //     this.unit = {
        //       name: '',
        //       code: '',
        //       description: '',
        //     };
        //     this.unitFormVisible = false;
        //     this.getList();
        //   })
        //   .catch(error => {
        //     // this.errors_exist = true;
        //     this.errors = error.response.data.errors;
        //     var offset = 0;
        //     Object.entries(this.errors).forEach(([key, value]) => {
        //       // console.log('entries: ',key, value, value[0]);
        //       this.$notify.error({
        //         title: 'Error',
        //         message: value[0],
        //         offset: offset,
        //       });
        //       offset += 60;
        //     });
        //     // console.log('Error:', this.errors);
        //   });
  
      }
    },
  }
}
</script>