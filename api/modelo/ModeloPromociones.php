<?php

class ModeloPromociones {
    
    public function branchIDPromociones($idBranch) {
        if($idBranch!=""){
            $sql = "select * from `tb_promotion_branch`a inner join `tb_promotion` b on(a.promotion_id =  b.promotion_id)  where branch_id='$idBranch'";
            return ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        }
    }
    
    public function categoryPromociones($idcat,$idPromotion) {
        if($idcat!="" && $idPromotion!=""){
            $sql = "select * from tb_promotion where category_id='$idcat' and promotion_id='$idPromotion'";
            return ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        }
        
    }
    
}
