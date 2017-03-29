<?php

/**
 * 给最初的基本DAO类提供基础接口
 * @author陆佰晓
 * @date 20160524
 */
interface IBaseDao {

    //获取表的总条数
    public function getCount();

    //获取表所有数据
    public function getAllData();

    //增加一条记录
    public function addOne();

    //删除
    public function deleteOneByKey($key, $keyPos);

    //修改
    public function modifyOneByKey($setPos,$setVal,$keyPos,$val);

    //查找-条件查找，返回一个服务条件的数据
    public function getOneBykey($key, $keyPos);

    //查找-条件查找,如果存在返回true.
    public function findOneBykey($key, $keyPos);

    //查找-查找所有符合条件的返回数组
    public function findArrayBykey($key, $keyPos);

    //查找-查找符合条件，按分页限制形式返回，返回数组
    public function getArrayBykeyLimit($orderKey, $page, $pageSize);
}
