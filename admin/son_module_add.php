<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
$link=connect();
$template['title']="子版块页面";

?>
<?php
/*函数集合*/
?>
<?php
$data_father_module = null;
$son_module['submit'] = null;
if (isset($_POST['submit'])){
    $query = "select * from sfk_father_module where id = '{$_POST['father_module_id']}'";
//    var_dump($query);
    $result_father_module = execute($link,$query);
    global $data_father_module;
    $data_father_module = mysqli_fetch_assoc($result_father_module);
//    var_dump($data_father_module);
//    var_dump($result_father_module);
//    result使用fetch获取的对象和result本身有很大区别
    if (mysqli_num_rows($result_father_module)==0){
        global $son_module;
        $son_module['submit'] = "fail";
    }
    else{
        global $son_module;
        $query = "insert into sfk_son_module(father_module_id, module_name, info, member_id, sort) values('{$_POST['father_module_id']}',
        '{$_POST['module_name']}','{$_POST['info']}','{$_POST['member_id']}','{$_POST['sort']}') ";
        execute($link,$query);
        $son_module['submit'] = "success";
//    执行成功！！！
    }
}
?>
<?php include 'inc/header.inc.php '?>
<div id="main">
    <div class="title">添加子版块</div>
    <form action="" method="post">
        <table class="list">
            <tr>
                <th>排序</th>
                <th>版块名称</th>
                <th>操作</th>
            </tr>
            <tr>
                <td>所述父板块</td>
                <td>
                    <select name="father_module_id" id="">
                        <option value="0">===请选择一个父板块===</option>
                        <?php
//                        link一个页面使用一个资源
                        $query = "select * from sfk_father_module";
                        $result_father = execute($link,$query);
                        while ($data_father = mysqli_fetch_assoc($result_father)){
                            echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
                        }
                        ?>
                    </select>
                </td>
                <td >
                    版块名称不得为空，最大不得超过66个字符
                </td>
            </tr>
            <tr>
                <td>版块名称</td>
                <td><input name="module_name" type="text" maxlength="60" size="20"/></td>
                <!--                    size表示输入框的宽度-->
                <td >
                    版块名称不得为空，最大不得超过66个字符
                </td>
            </tr>
            <tr>
                <td>板块简介</td>
                <td>
                    <textarea name="info" id="" cols="30" rows="10"></textarea>
                </td>
                <!--                    size表示输入框的宽度-->
                <td >
                    板块简介不得超过255个字符
                </td>
            </tr>
            <tr>
                <td>版主</td>
                <td>
                    <select name="member_id" id="">
                        <option value="0">===请选择一个会员作为版主===</option>
                    </select>
                </td>
                <td >
                    可以在这边选择一个版主作为会员
                </td>
            </tr>
            <tr>
                <td>排序</td>
                <td><input name="sort" value="" type="text"/></td>
                <td>
                    填写一个数字即可
                </td>
            </tr>
        </table>
        <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
        <?php
       /* if (isset($son_module['submit']))
        var_dump($son_module);
        exit();*/
        if (isset($son_module))
        {
            if ($son_module['submit']=="success"){
                $father_module_name = $data_father_module['module_name'];
                echo "<p>添加子版块成功，所属父板块为 : {$father_module_name},子版块名 ： {$_POST['module_name']},
                板块信息 : {$_POST['info']},排序号 ： {$_POST['sort']}</p>";
            }
            elseif ($son_module['submit'] == "fail"){
                echo "父板块不存在，无法添加子板块";
            }
        }

        ?>
    </form>
</div>

<?php include 'inc/footer.inc.php'?>
