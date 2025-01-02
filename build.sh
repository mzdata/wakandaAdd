 

if test -d output; then
    echo "文件夹存在"
else
     mkdir output
fi

cp -rf Common output/  

####增加线上配置，连接数据库等
if test -d output/Conf; then
    echo "文件夹存在"
else
     mkdir output/Conf
     
fi

cp -rf  ConfProd/* output/Conf/ 

cp -rf Lib output/
cp -rf login output/
cp -rf Public output/
cp -rf ThinkPHP output/
cp -rf tools output/
cp -rf Tpl output/ 


if test -d output/uppicture; then
    echo "文件夹存在"
else
     mkdir output/uppicture
fi

cp -rf *.php output/