drop  table  词条;
drop  table  销售;
/*drop  table  购买;*/
drop  table  商家;
drop  table  商品;
drop  table  用户;

create  table  用户
(
    用户编号  INT NOT NULL AUTO_INCREMENT,
	用户名  varchar(50)  not  null  unique check(length(用户名)>=5  and  length(用户名)<=25),
    密码    varchar(40)   not  null  check(length(密码)>=6  and  length(密码)<=20),
    用户头像  varchar(200)  default 'login/img/01.jpg',
/*    邮箱    varchar(40)   not  null,
    手机号  long   not  null  check(length(手机号)<>11),
    地址    varchar(100),*/
    创建词条个数  int  default 0,
    类型 int,
    等级    int,
    primary  key  (用户编号)
);

create  table  商家
(
   用户名  varchar(50),
   商店名    varchar(40),
   地址      varchar(100),
   印象标签  varchar(8000),
   口碑      int  check (口碑>=0  and  口碑<=100) , 
   primary  key (商店名,地址),
   foreign  key  (用户名)  references  用户  (用户名)
);

create  table  商品
(
	用户名  varchar(50),
	商品名   varchar(40),
    类型	 varchar(20),
    商标     varchar(40),
    条码     long  check(length(条码)<>13),  
    商品创建时间  datetime,
    商品图片 varchar(100)  default 'img/default.jpg',
    primary key  (商品名),
    foreign  key  (用户名)  references  用户  (用户名)
);



create  table  销售
(
   用户名    varchar(50),
   商店名    varchar(40),
   地址      varchar(100),
   商品名    varchar(40),
   销售价格  float,
   primary  key  (商店名,地址,商品名),
   foreign  key  (商店名,地址)  references  商家  (商店名,地址),
   foreign  key  (商品名)   references  商品  (商品名),
   foreign  key  (用户名)  references  用户  (用户名)
);
/*
create  table  购买
(
   用户名  varchar(50),
   商店名  varchar(40),
   地址    varchar(100),
   商品名  varchar(40),
   数量    int,
   primary  key  (用户名,商店名,地址,商品名),
   foreign  key  (用户名)  references  用户  (用户名),
   foreign  key  (商店名,地址)  references  商家  (商店名,地址),
   foreign  key  (商品名)   references  商品  (商品名)
);
*/
create  table  词条
(
   用户名    varchar(50),
   商店名    varchar(40),
   地址      varchar(100),
   商品名    varchar(40),
   商品图片  varchar(100)  default 'img/default.jpg',
   销售价格  float  not  null,
   条码      long  check(length(条码)<>13),  
   词条创建时间  datetime,
   primary  key  (用户名,商店名,地址,商品名),
   foreign  key  (用户名)  references  用户  (用户名),
   foreign  key  (商店名,地址,商品名)  references  销售  (商店名,地址,商品名)
);

insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("inmyworld",md5("imw123456"),2,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("iamzhangsan",md5("zs123456"),2,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("iamlisi",md5("ls123456"),3,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("iamwangwu",md5("ww123456"),1,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("iamzhaoliu",md5("zl123456"),0,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("iamsunqi",md5("sq123456"),0,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("wustadmin",md5("12345678"),0,1,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("wustzz",md5("12345678"),0,1,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("wustmanager",md5("12345678"),0,2,0);


insert  into  商家  values  ("wustadmin","南一超市","武汉科技大学南一楼下","#inmyworld:种类很多",85);
insert  into  商家  values  ("wustadmin","南十超市","武汉科技大学南十楼下","#inmyworld:种类比较单一",80);
insert  into  商家  values  ("wustadmin","南十一超市","武汉科技大学南十一楼下","#inmyworld:老板人很好",90);
insert  into  商家  values  ("wustadmin","南十自动贩卖机","武汉科技大学南十宿舍楼下","#iamzhangsan:商品种类不换",80);
insert  into  商家  values  ("wustadmin","南八星星猫超市","武汉科技大学南八楼下","#iamzhangsan:主要是生活用品",80);
insert  into  商家  values  ("wustadmin","南二浪漫满屋","武汉科技大学南二商业街","#iamzhangsan:面包奶茶味道不错",88);
insert  into  商家  values  ("wustzz","涛涛平价超市","丽水南路东澜岸","#iamlisi:物美价廉哦",92);
insert  into  商家  values  ("wustzz","中百超市","丽水南路东澜岸","#iamlisi:看起来比较正品",87);
insert  into  商家  values  ("wustzz","罗蒂爸爸","丽水南路东澜岸二楼","#iamlisi:味道还不错",90);
insert  into  商家  values  ("wustzz","南二泷饮天下","武汉科技大学南二商业街","#iamwangwu:无",80);

insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustadmin","虎皮面包","休闲零食","面包","result/img/hpmb.jpg","2018-3-12 21:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustadmin","脉动青柠味","奶品水饮","饮料","result/img/qn_md.jpg","2018-3-13 08:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustadmin","脉动芒果味","奶品水饮","饮料","result/img/mg_md.jpg","2018-3-13 08:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustadmin","AD钙奶","奶品水饮","饮料","result/img/adgn.jpg","2018-3-11 21:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustadmin","真巧巧克力味","休闲零食","饼干","result/img/default.jpg","2018-3-13 08:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustadmin","真巧草莓味","休闲零食","饼干","result/img/cm_zq.jpg","2018-3-13 08:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustadmin","飞旺","休闲零食","辣条","result/img/default.jpg","2018-3-13 08:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustzz","旺仔QQ糖","休闲零食","糖果","result/img/wzqqt.jpg","2018-3-12 21:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustzz","西瓜","生鲜水果","水果","result/img/xg.jpg","2018-3-12 08:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustzz","柠檬水","奶品水饮","奶茶","result/img/nms.jpg","2018-3-10 21:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustzz","蜂蜜柚子茶","奶品水饮","奶茶","result/img/fmyzc.jpg","2018-3-9 21:07:00");
insert  into  商品  (用户名,商品名,类型,商标,商品图片,商品创建时间)  values  ("wustzz","金桔柠檬","奶品水饮","奶茶","result/img/default.jpg","2018-3-13 08:07:00");

/*
insert  into  用户  (用户名,密码,邮箱,手机号,创建词条个数,等级)  values  ("inmyworld",md5("imw123456"),"imw12345678@qq.com",15671563320,0,0);
insert  into  用户  (用户名,密码,邮箱,手机号,创建词条个数,等级)  values  ("iamzhangsan",md5("zs123456"),"zs12345678@qq.com",15671563321,0,0);
insert  into  用户  (用户名,密码,邮箱,手机号,创建词条个数,等级)  values  ("iamlisi",md5("ls123456"),"ls12345678@qq.com",15671563322,0,0);
insert  into  用户  (用户名,密码,邮箱,手机号,创建词条个数,等级)  values  ("iamwangwu",md5("ww123456"),"ww12345678@qq.com",15671563323,0,0);
insert  into  用户  (用户名,密码,邮箱,手机号,创建词条个数,等级)  values  ("iamzhaoliu",md5("zl123456"),"zl12345678@qq.com",15671563324,0,0);
insert  into  用户  (用户名,密码,邮箱,手机号,创建词条个数,等级)  values  ("iamsunqi",md5("sq123456"),"sq12345678@qq.com",15671563325,0,0);


insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("inmyworld",md5("imw123456"),2,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("iamzhangsan",md5("zs123456"),2,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("iamlisi",md5("ls123456"),3,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("iamwangwu",md5("ww123456"),1,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("iamzhaoliu",md5("zl123456"),0,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("iamsunqi",md5("sq123456"),0,0,0);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("wustadmin",md5("12345678"),0,1,1);
insert  into  用户  (用户名,密码,创建词条个数,类型,等级)  values  ("wustmanager",md5("12345678"),0,1,2);
*/

insert  into  销售  values  ("wustzz","南二泷饮天下","武汉科技大学南二商业街","柠檬水",5);
insert  into  销售  values  ("wustzz","南二泷饮天下","武汉科技大学南二商业街","蜂蜜柚子茶",6);
insert  into  销售  values  ("wustzz","南二泷饮天下","武汉科技大学南二商业街","金桔柠檬",4);
insert  into  销售  values  ("wustzz","罗蒂爸爸","丽水南路东澜岸二楼","柠檬水",3);
insert  into  销售  values  ("wustzz","罗蒂爸爸","丽水南路东澜岸二楼","蜂蜜柚子茶",4);
insert  into  销售  values  ("wustzz","南一超市","武汉科技大学南一楼下","虎皮面包",4.5);
insert  into  销售  values  ("wustadmin","南一超市","武汉科技大学南一楼下","真巧巧克力味",12);
insert  into  销售  values  ("wustadmin","南一超市","武汉科技大学南一楼下","真巧草莓味",12);
insert  into  销售  values  ("wustadmin","南一超市","武汉科技大学南一楼下","AD钙奶",2);
insert  into  销售  values  ("wustadmin","南十自动贩卖机","武汉科技大学南十宿舍楼下","AD钙奶",2.2);
insert  into  销售  values  ("wustadmin","南十自动贩卖机","武汉科技大学南十宿舍楼下","脉动青柠味",4.2);
insert  into  销售  values  ("wustadmin","南十自动贩卖机","武汉科技大学南十宿舍楼下","旺仔QQ糖",3.5);
insert  into  销售  values  ("wustadmin","南十超市","武汉科技大学南十楼下","旺仔QQ糖",3);
insert  into  销售  values  ("wustzz","中百超市","丽水南路东澜岸","旺仔QQ糖",3);
insert  into  销售  values  ("wustzz","中百超市","丽水南路东澜岸","脉动青柠味",4);

insert  into  词条  (用户名,商店名,地址,商品名,商品图片,销售价格,词条创建时间)  values  ("inmyworld","南二泷饮天下","武汉科技大学南二商业街","柠檬水","result/img/nms.jpg",5,"2018-3-10 21:07:00");
insert  into  词条  (用户名,商店名,地址,商品名,商品图片,销售价格,词条创建时间)  values  ("inmyworld","南二泷饮天下","武汉科技大学南二商业街","蜂蜜柚子茶","result/img/fmyzc.jpg",6,"2018-3-9 21:07:00");
insert  into  词条  (用户名,商店名,地址,商品名,商品图片,销售价格,词条创建时间)  values  ("iamzhangsan","罗蒂爸爸","丽水南路东澜岸二楼","柠檬水","result/img/nms.jpg",3,"2018-3-11 21:07:00");
insert  into  词条  (用户名,商店名,地址,商品名,商品图片,销售价格,词条创建时间)  values  ("iamzhangsan","罗蒂爸爸","丽水南路东澜岸二楼","蜂蜜柚子茶","result/img/fmyzc.jpg",4,"2018-3-11 21:07:00");
insert  into  词条  (用户名,商店名,地址,商品名,商品图片,销售价格,词条创建时间)  values  ("iamlisi","南十自动贩卖机","武汉科技大学南十宿舍楼下","AD钙奶","result/img/adgn.jpg",2.2,"2018-3-11 21:07:00");
insert  into  词条  (用户名,商店名,地址,商品名,商品图片,销售价格,词条创建时间)  values  ("iamlisi","南一超市","武汉科技大学南一楼下","虎皮面包","result/img/hpmb.jpg",4.5,"2018-3-12 21:07:00");
insert  into  词条  (用户名,商店名,地址,商品名,商品图片,销售价格,词条创建时间)  values  ("iamlisi","南一超市","武汉科技大学南一楼下","AD钙奶","result/img/adgn.jpg",2,"2018-3-12 21:07:00");
insert  into  词条  (用户名,商店名,地址,商品名,商品图片,销售价格,词条创建时间)  values  ("iamwangwu","南十超市","武汉科技大学南十楼下","旺仔QQ糖","result/img/wzqqt.jpg",3,"2018-3-12 21:07:00");

update  用户  set  密码=md5("12345678")  where  用户名="wustmanager";
/*
update  用户  set  创建词条个数=1  where  用户名="iamwangwu";
update  用户  set  创建词条个数=2  where  用户名="inmyworld"  or  用户名="iamzhangsan";
update  用户  set  创建词条个数=3  where  用户名="iamlisi";
update  用户  set  创建词条个数=3  where  用户名="inmyworld";

delete  from  词条  where  商品名='AD钙奶'  and  销售价格=3;
delete  from  商品  where  商品名='乐事薯片';
delete  from  商家  where  口碑=32434;
*/
select  商品.商标,商品.商品图片,词条.商店名,词条.地址,词条.商品名,词条.销售价格,商家.印象标签,商家.口碑,词条.词条创建时间  from  词条,商品,商家  
	where  词条.商店名=商家.商店名  and  词条.地址=商家.地址  and  商品.商品名=词条.商品名;  /*and  
		(商品.商标='饮料'  or  词条.商品名='饮料');*/
        
select * from 词条,商家 where 词条.商店名=商家.商店名  and  词条.地址=商家.地址 and 词条.词条创建时间>= DATE_SUB(curdate(), INTERVAL 1 DAY) and 词条.词条创建时间< current_date() order by 商家.口碑  DESC;

select * from tt where f1 between DATE_SUB(curdate(), INTERVAL 1 DAY) and current_date();
select * from tt 
where f1 >= DATE_SUB(curdate(), INTERVAL 1 DAY) 
  and f1 <  current_date();

insert  into  词条  (用户名,商店名,地址,商品名,商品图片,销售价格,词条创建时间)  values('{$用户名}','{$商店名}','{$地址}','{$商品名}','$pic','{$销售价格}','{$词条创建时间}');
