<?php
/**
 * 添加商品
 * @return string
 */
function addPro(){
    $arr = $_POST;
    $arr['pubTime'] = time();
    $path = "./uploads";
    $uploadFiles = uploadFile($path);
    if (is_array($uploadFiles) && $uploadFiles){
        foreach ($uploadFiles as $key=>$uploadFile){
            thumb($path."/".$uploadFile['name'],"../image_50/".$uploadFile['name'],50,50);
            thumb($path."/".$uploadFile['name'],"../image_220/".$uploadFile['name'],220,220);
            thumb($path."/".$uploadFile['name'],"../image_350/".$uploadFile['name'],350,350);
            thumb($path."/".$uploadFile['name'],"../image_800/".$uploadFile['name'],800,800);
        }
    }
    $res = insert("imooc_pro", $arr);
    $pid = getInsertId();
    if ($res && $pid){
        foreach ($uploadFiles as $uploadFile){
            $arr1['pid'] = $pid;
            $arr1['albumPath']=$uploadFile['name'];
            addAlbum($arr1);
        }
        $mes = "<p>添加成功！<a href = 'addPro.php' target='mainFrame'>继续添加</a>|<a href = 'listPro.php' target='mainFrame'>查看商品列表</a></p>";
    }else {
        //删除相应的文件
        foreach ($uploadFiles as $uploadFile){
            if (file_exists("../image_50/".$uploadFile['name'])){
                unlink("../image_50/".$uploadFile['name']);
            }
            if (file_exists("../image_220/".$uploadFile['name'])){
                unlink("../image_220/".$uploadFile['name']);
            }
            if (file_exists("../image_800/".$uploadFile['name'])){
                unlink("../image_800/".$uploadFile['name']);
            }
            if (file_exists("../image_350/".$uploadFile['name'])){
                unlink("../image_350/".$uploadFile['name']);
            }
        }
        $mes = "<p>添加失败！<a href = 'addPro.php' target='mainFrame'>重新添加</a>";
    }
    return $mes;
}
function delPro($id){
    $where = "id=$id";
    $res = delete("imooc_pro",$where);
    //根据id找到所有的图片
    $proImgs = getAllImgByProId($id);
    if ($proImgs && is_array($proImgs)){
        foreach ($proImgs as $proImg){
            if (file_exists("uploads/".$proImg['albumPath'])){
                unlink("uploads/".$proImg['albumPath']);
            }
            if (file_exists("../image_50/".$proImg['albumPath'])){
                unlink("../image_50/".$proImg['albumPath']);
            }
            if (file_exists("../image_220/".$proImg['albumPath'])){
                unlink("../image_220/".$proImg['albumPath']);
            }
            if (file_exists("../image_350/".$proImg['albumPath'])){
                unlink("../image_350/".$proImg['albumPath']);
            }
            if (file_exists("../image_800/".$proImg['albumPath'])){
                unlink("../image_800/".$proImg['albumPath']);
            }
        }
    }
    $where1 = "pid={$id}";
    $res1 = delete("imooc_album",$where1);
    if ($res && $res1){
        $mes = "<p>删除成功!<br/><a href = 'listPro.php' target='mainFrame'>查看商品列表</a></p>";
    }else {
        $mes = "<p>删除失败!<br/><a href = 'listPro.php' target='mainFrame'>重新删除</a></p>";
    }
    return $mes;
}
/**
 * 得到商品的所有信息
 * @return multitype:
 */
function getAllProductsByAdmin(){
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName from imooc_pro as p join imooc_cate as c on p.cId = c.id";
    $rows = fetchAll($sql);
    return $rows;
}

function getAllImgByProId($id){
    $sql = "select a.albumPath from imooc_album a where pid={$id}";
    $rows = fetchAll($sql);
    return $rows;
}
/**
 * 根据id得到商品的详细信息
 * @param int $id
 * @return array
 */
function getProById($id){
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate as c on p.cId = c.id where p.id = $id";
    $row = fetchOne($sql);
    return $row;
}
/**
 * 编辑商品信息
 * @param int $id
 * @return string
 */
function editPro($id){
    $arr = $_POST;
    $path = "./uploads";
    $uploadFiles = uploadFile($path);
    if (is_array($uploadFiles) && $uploadFiles){
        foreach ($uploadFiles as $key=>$uploadFile){
            thumb($path."/".$uploadFile['name'],"../image_50/".$uploadFile['name'],50,50);
            thumb($path."/".$uploadFile['name'],"../image_220/".$uploadFile['name'],220,220);
            thumb($path."/".$uploadFile['name'],"../image_350/".$uploadFile['name'],350,350);
            thumb($path."/".$uploadFile['name'],"../image_800/".$uploadFile['name'],800,800);
        }
    }
    $where = "id={$id}";
    $res = update("imooc_pro", $arr,$where);
    $pid = $id;
    if ($res && $pid){
        if ($uploadFiles && is_array($uploadFiles)){
            foreach ($uploadFiles as $uploadFile){
                $arr1['pid'] = $pid;
                $arr1['albumPath']=$uploadFile['name'];
                addAlbum($arr1);
            }
        }
        $mes = "<p>修改成功！<a href = 'listPro.php' target='mainFrame'>查看商品列表</a></p>";
    }else {
        if (is_array($uploadFiles) && $uploadFiles){
            //删除相应的文件
            foreach ($uploadFiles as $uploadFile){
                if (file_exists("../image_50/".$uploadFile['name'])){
                    unlink("../image_50/".$uploadFile['name']);
                }
                if (file_exists("../image_220/".$uploadFile['name'])){
                    unlink("../image_220/".$uploadFile['name']);
                }
                if (file_exists("../image_800/".$uploadFile['name'])){
                    unlink("../image_800/".$uploadFile['name']);
                }
                if (file_exists("../image_350/".$uploadFile['name'])){
                    unlink("../image_350/".$uploadFile['name']);
                }
            }
        }
        $mes = "<p>修改失败！<a href = 'listPro.php' target='mainFrame'>重新修改</a>";
    }
    return $mes;
}

/**
 * 检查分类下是否有产品
 * @param int $cid
 * @return array:
 */
function checkProExist($cid){
    $sql  = "select * from imooc_pro where cId = {$cid}";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 * 得到所有商品
 * @return array
 */
function getAllPros(){
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate as c on p.cId = c.id";
    $rows = fetchAll($sql);
    return $rows;
}
/**
 * 通过cid查找4条商品数
 * @param int $cid
 * @return array:
 */
function getProsById($cid){
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate as c on p.cId = c.id where p.cId={$cid} limit 4";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 * 根据cid得到小产品
 * @param int $cid
 * @return array:
 */
function getSmallProsById($cid){
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate as c on p.cId = c.id where p.cId={$cid} limit 4,4";
    $rows = fetchAll($sql);
    return $rows;
}
/**
 * 得到商品ID和商品名称
 * @return multitype:
 */
function getProInfo(){
    $sql = "select id,pName from imooc_pro order by id asc";
    $rows = fetchAll($sql);
    return $rows;
}
