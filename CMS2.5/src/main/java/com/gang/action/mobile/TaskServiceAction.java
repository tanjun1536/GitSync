package com.gang.action.mobile;

import com.gang.action.BaseAction;

import com.gang.entity.product.Product;
import com.gang.entity.task.Task;
import com.gang.entity.task.TaskHistory;
import com.gang.entity.user.User;

import com.gang.service.mobile.TaskService;
import com.gang.service.wssvc.Generator;
import com.gang.service.wssvc.JSONArrayGenerator;
import com.gang.service.wssvc.JSONGenerator;

import java.util.Date;
import java.util.List;


public class TaskServiceAction extends BaseAction {
    private String user_name;
    private Integer task_id;
    private String hash_password;
    private String active_key;
    private String task_status;
    public TaskService service;

    public void setUser_name(String user_name) {
        this.user_name = user_name;
    }

    public void setTask_id(Integer task_id) {
        this.task_id = task_id;
    }

    public String getTask_status() {
        return task_status;
    }

    public void setTask_status(String task_status) {
        this.task_status = task_status;
    }

    public String getHash_password() {
        return hash_password;
    }

    public void setHash_password(String hash_password) {
        this.hash_password = hash_password;
    }

    public String getActive_key() {
        return active_key;
    }

    public void setActive_key(String active_key) {
        this.active_key = active_key;
    }

    public TaskService getService() {
        return service;
    }

    public void setService(TaskService service) {
        this.service = service;
    }

    public void list() {
        User user = service.get(User.class, "loginName", user_name);
        JSONGenerator json = CheckUser(user, hash_password);

        if (json == null) {
            json = new JSONGenerator();

            String sql = "SELECT  t.id,t.name,t.type,t.description,t.enable,t.reward,t.times_perday  ,CASE WHEN t.times_perday=h.doCount THEN '11' ELSE '10' END  AS `status` FROM task t  LEFT JOIN (SELECT * FROM taskhistory  WHERE DATEDIFF(doDate, SYSDATE()) = 0 AND username = '" +
                user_name + "') h ON t.`id` = h.taskId ";
            List<Task> list = service.getList(Task.class, sql);

            JSONArrayGenerator arrayGenerator = new JSONArrayGenerator();

            if (list != null) {
                for (Task task : list) {
                    JSONGenerator jsonTask = new JSONGenerator();
                    jsonTask.addGenerator(new Generator("task_id", task.getId()));
                    jsonTask.addGenerator(new Generator("type", task.getType()));
                    jsonTask.addGenerator(new Generator("name", task.getName()));
                    jsonTask.addGenerator(new Generator("description",
                            task.getDescription()));
                    jsonTask.addGenerator(new Generator("times_perday",
                            task.getTimes_perday()));
                    jsonTask.addGenerator(new Generator("status",
                            task.getStatus()));
                    jsonTask.addGenerator(new Generator("enable",
                            task.getEnable()));
                    jsonTask.addGenerator(new Generator("reward",task.getReward()));
                    arrayGenerator.addGenerator(jsonTask);
                }
            }

            json.addGenerator(new Generator("result", Success));
            json.addGenerator(new Generator("tasks", arrayGenerator));
        }

        Write(json.toString());
    }

    public void status() {
        User user = service.get(User.class, "loginName", user_name);
        JSONGenerator json = CheckLogin(user, hash_password);

        if (json == null) {
            json = new JSONGenerator();

            String sql = "SELECT  t.id,t.name,t.type,t.description,t.enable,t.reward,t.times_perday  ,CASE WHEN t.times_perday=h.doCount THEN '11' ELSE '10' END  AS `status` FROM task t  LEFT JOIN (SELECT * FROM taskhistory  WHERE DATEDIFF(doDate, SYSDATE()) = 0 AND username = '" +
                user_name + "') h ON t.`id` = h.taskId where t.id=" + task_id;
            Task task = service.get(Task.class, sql);

            if (task != null) {
                json.addGenerator(new Generator("result", Success));
                json.addGenerator(new Generator("task_id", task.getId()));
                json.addGenerator(new Generator("type", task.getType()));
                json.addGenerator(new Generator("name", task.getName()));
                json.addGenerator(new Generator("description",
                        task.getDescription()));
                json.addGenerator(new Generator("times_perday",
                        task.getTimes_perday()));
                json.addGenerator(new Generator("status", task.getStatus()));
                json.addGenerator(new Generator("enable", task.getEnable()));
            }
        }

        Write(json.toString());
    }

    public void update() {
        JSONGenerator result = Success;
        User user = service.get(User.class, "loginName", user_name);
        JSONGenerator json = CheckUser(user, hash_password);

        if (json == null) {
            json = new JSONGenerator();

            try {
                TaskHistory history = null;

                //查询任务
                Task task = service.get(Task.class, task_id);

                //查询任务历史
                String sql = "select * from taskhistory where datediff(doDate,sysdate())=0 and username='" +
                    user_name + "' and taskId=" + task_id;

                //比较
                List<TaskHistory> list = service.getList(TaskHistory.class, sql);

                //如果已经做过该任务并且任务次数小于规定次数
                if ((list != null) && (list.size() > 0)) {
                    history = list.get(0);
                    
                    if (history.getDoCount() < task.getTimes_perday()) {
                        history.setDoCount(history.getDoCount() + 1);
                    }
                    else//已经做了
                    {
                    	
                    	result=new JSONGenerator().addGenerator(new Generator("error", "10001"))
                        .addGenerator(new Generator("title", "调用失败"))
                        .addGenerator(new Generator("message", "重复提交"));
                    	json.addGenerator(new Generator("result", result));
                    	Write(json.toString());
                    	return;
                    	//10001重复提交
                    }
                   
                } else {
                    history = new TaskHistory();
                    history.setDoCount(1);
                    history.setDoDate(new Date());
                    history.setUserName(user_name);
                    history.setTaskId(task_id);
                }

                service.saveTaskHistory(history, user_name, task.getReward());

                json.addGenerator(new Generator("result", result));
                json.addGenerator(new Generator("task_id", task.getId()));
                json.addGenerator(new Generator("type", task.getType()));
                json.addGenerator(new Generator("name", task.getName()));
                json.addGenerator(new Generator("description",
                        task.getDescription()));
                json.addGenerator(new Generator("times_perday",
                        task.getTimes_perday()));
                json.addGenerator(new Generator("status", "11"));
                json.addGenerator(new Generator("enable", task.getEnable()));
                json.addGenerator(new Generator("reward", task.getReward()));
                json.addGenerator(new Generator("task_process", history.getDoCount()+"/"+task.getTimes_perday()));
            } catch (Exception e) {
                result = Error.addGenerator(new Generator("message",
                            e.getMessage()));
                json.addGenerator(new Generator("result", result));
            }

        }

        Write(json.toString());
    }
}
