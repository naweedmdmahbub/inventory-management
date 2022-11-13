<template>
  <tr>
    <td>
      <el-row :gutter="20">
          <el-col :span="11" :offset="1">
            <el-form-item :label="$t('work.workTypeItem')" prop="name">
              <el-input v-model="workTypeItem.name" :placeholder="$t('work.workTypeItem')" />
            </el-form-item>
          </el-col>
          <el-col :span="11" :offset="1">
              <el-form-item :label="$t('common.description')" prop="description">
                  <el-input v-model="workTypeItem.description" type="textarea" :placeholder="$t('common.description')" />
              </el-form-item>
          </el-col>
      </el-row>

      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.length')" prop="length">
                  <el-input v-model="workTypeItem.length" :placeholder="$t('work.length')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.breadth')" prop="breadth">
                  <el-input v-model="workTypeItem.breadth" :placeholder="$t('work.breadth')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.height')" prop="height">
                  <el-input v-model="workTypeItem.height" :placeholder="$t('work.height')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
      </el-row>

              
      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
            <el-form-item :label="$t('common.unit_id')" prop="unit_id">
              <el-select v-model="workTypeItem.unit_id" placeholder="Please Select Unit" :disabled="mode === 'view'" width="100%">
                  <el-option v-for="unit in units"
                            :key="unit.id"
                            :label="unit.name"
                            :value="unit.id" />
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.nos')" prop="nos">
                  <el-input v-model="workTypeItem.nos" :placeholder="$t('work.nos')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.quantity')" prop="quantity">
                  <el-input v-model="workTypeItem.quantity" :disabled="true" :placeholder="$t('work.quantity')" />
              </el-form-item>
          </el-col>
      </el-row>
      
    </td>
  </tr>
</template>


<script>
import axios from 'axios';
export default {
  props: ['structureType', 'workTypeItem', 'mode'],
  data() {
    return {
      units: [],
    }
  },
  async mounted(){
    let models = ['Unit'];
    await axios.post('/api/get-model-data', models).then(({ data }) => {
      this.units = data[0];
    });
  },
  async created(){
    console.log('workTypeItem create:', this.structureType, this.workTypeItem);
  },
  
  methods: {
    async calculateQuantity(){
      console.log('calculateQuantity item: ', this.workTypeItem);
      let quantity = 1;
      quantity = this.workTypeItem.length ? this.workTypeItem.length * quantity : quantity;
      quantity = this.workTypeItem.breadth ? this.workTypeItem.breadth * quantity : quantity;
      quantity = this.workTypeItem.height ? this.workTypeItem.height * quantity : quantity;
      quantity = this.workTypeItem.nos ? this.workTypeItem.nos * quantity : quantity;
      this.workTypeItem.quantity = parseFloat(quantity).toFixed(6);
      // this.workTypeItem.quantity = parseFloat(this.workTypeItem.length * this.workTypeItem.breadth * this.workTypeItem.height * this.workTypeItem.nos).toFixed(6);
      console.log('calculateQuantity: ', this.workTypeItem);
      // this.$emit('quantityCalculated');
    },
  }
}
</script>

<style scoped>
  td {
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    border: .2px solid;
    padding: 8px;
    margin: 5px;
  }
</style>