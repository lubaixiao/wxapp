<?php
appLogs("StudentScore加载");
/**
 * Description of StudentScoreDAO
 * 用户储存的成绩信息的表
 * @author 陆佰晓
 */
class StudentScoreDAO extends BaseDAOImpl {

    /**
     * 初始化数据
     */
    function __construct() {
        $this->table = "student_score";
        $this->table_column = "student,point,score_data";
        $this->table_value_tpl = "'%s',%f,'%s'";
        parent::__construct();
    }
}
