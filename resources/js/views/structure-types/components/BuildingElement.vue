<template>
  <tr>
    <td>
      <el-row :gutter="20">
          <el-col :span="11" :offset="1">
            <el-form-item :label="$t('work.workTypeItem')" prop="name">
              <el-input v-model="workTypeItem.name" :placeholder="$t('work.breadth')" />
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
                  <el-input v-model="workTypeItem.quantity" :disabled="true" :placeholder="$t('work.quantity')" @change="calculateQuantity" />
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
  watch: {
    workTypeItem: {
      handler(newValue, oldValue) {
        // Note: `newValue` will be equal to `oldValue` here
        // on nested mutations as long as the object itself
        // hasn't been replaced.
      },
      deep: true
    }
  },
  async mounted(){
    var models = ['Unit'];
    await axios.post('/api/get-model-data', models).then(({ data }) => {
      console.log(data);
      this.units = data[0];
      console.log('mounted', this.units);
    });
  },
  async created(){
    console.log('workTypeItem create:', this.structureType);
  },
  
  methods: {
    async calculateQuantity(){
      // let quantity = await this.cal();
      var item = { ...this.workTypeItem };
      var quantity = 1;
      quantity = item.length ? item.length * quantity : quantity;
      quantity = item.breadth ? item.breadth * quantity : quantity;
      quantity = item.height ? item.height * quantity : quantity;
      quantity = item.nos ? item.nos * quantity : quantity;
      this.workTypeItem.quantity = parseFloat(quantity).toFixed(6);
      // this.workTypeItem.quantity = parseFloat(item.length * item.breadth * item.height * item.nos).toFixed(6);
      console.log('calculateQuantity: ', this.workTypeItem);
    },
    // cal(){
    //   var item = {...this.workTypeItem};
    //   var quantity = 1;
    //   quantity = item.length ? item.length * quantity : quantity;
    //   quantity = item.breadth ? item.breadth * quantity : quantity;
    //   quantity = item.height ? item.height * quantity : quantity;
    //   quantity = item.nos ? item.nos * quantity : quantity;
    //   // this.workTypeItem.quantity = parseFloat(quantity).toFixed(6);
    //   return quantity;
    // }
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