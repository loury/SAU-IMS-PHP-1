<?php

/**
 * 校社联管理员任务类
 * 只在SauAdmin中被new
 */
defined("APP") or die("error");

class SauTask extends BaseAdminTask
{

    //****校社联管理员没有未读任务
 
    /**
     * 获得所有社团管理员的id和名字
     * 不包括校社联自己
     * @return [type] [description]
     */
    public function getAllClubAdmin(){
       $sql = "select id,name 
                from user u u
                join userinfo ui where u.id = ui.user_id;
                where u.right = ? and u.club_id not in ?";
        $conn = Database::getInstance();
        try{

            $stmt = $conn -> prepare($sql);
            $right =1;//管理员权限
            $stmt->bindParam(1,$right);
            $stmt->bindParam(2,$this->getSauId());//校社联id，去掉校社联
            if(! $stmt -> execute()){
                return false;//失败返回false
            }
            
            $ids = array();
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                $tasks[] = $row;
            }
            return $tasks;//没查询到信息则返回的是空数组
            
        }catch(PDOException $e){
           // echo "出错信息：".$e->getMessage();//测试用
            return false;//sql语句出错
        }
    }


 
    
}