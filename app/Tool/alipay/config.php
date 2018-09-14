<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016091600527015",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAnhz9zXl+SzpjvxbKaolyXECvVh5UvyIiSg4TaZlZWbkAUdJ1
flzlcczuLClH2UpVn+e5EGIHIyT7rQwf098bgcnxkG4pmciYJYO8DclbID+iIUma
e0lN4ZMTeRi56zxwILIsQwTm2fzNkm2aOHO7mM0Vi9lWvoXVB0g2p/H/3OJP8UId
/5aSX+52dGmX7MxHuL4BPCRLWVE0uQVGRAKbQYtvw5k24XkwGe98JH5polgs/2Y9
jfoSZxGk+Pq3g0BnPObJh8reBUbp1Mc8/W5a6CM1upOOVuoq8F8iY8AATLVijYcO
Pn6enxtoYTIyl83b6M4TqpGkYG9NHb2gNAsf/wIDAQABAoIBAQCcWiDkmnq4G3Jd
mUTq2yYaceCw8WduZmuv/YFW0EzZ+6aEQvDq1yQRR8xSITQqfGZ1rOiFedqC92Rk
9/NVSW/jBXZ6E2XR69oAZueEXpRdLG/AKQ+5UIDSSuVbv4bCRs6+llJMp8E82M/U
N8vkfRWKgWsIExDDcIZ7H/7kTttsaVTKa6eOR+gbc58zR2iGrcKrJwAFfI25E8eD
+fmP0tytHx8q6vSSRAVJkIyA9nWjZj0QpLlnmhF3BjLGDv7qvGHsIJFH/tNJZFc2
0xxuN68PXol3PhsWyfcGWLQqqXbv0AH5mzUWqQwoNMnXqu1VWKoL7vCff0kZy3W+
/820DoTJAoGBANIpENlGC9fKyrGvBS3g8jam3gWk+WUSEe0k3QvP/cICVIbgAjxE
yeCTtLIzV/wD3l/MCMI7Q6IaeAKIbjWnpsLiuObNIbdm5msOOs43AUTabUv53XaW
s43422xEhjGN8kMWJwUdWFePU/h/KgxU9Dcyl3/2FMu9C6teNBiJ2OwbAoGBAMCZ
t3ntGxpSagcxpA9738f+3zMwAIt0/QhWT58Xztbyry4WmyHzfOduOJWYkzvb6uPF
wpMnPzCnRCg7SQ/SIWA3pQ2rYIWDYwJT/+ldMEqnchnPyXOLuBLPyNh6sqhI9rqi
oQaAzYeFFIZakJ3fL9bGLQwCo3wRtDWqS31KzFHtAoGAe82DRmt0KJAnLdsLswYz
yawtWKfh3v9xHgE8UmwZccPLpZSq3HQtdKWuqdeDOkvRIR/h/QHKiuEK13slaWg0
3dOP1y76cL8md+RvEfHnRndiMYKlSunmJnl2UWZgoyqaj5iqLeImm5YsglPvIkqd
fzLHerMtdwQLrs0U5Wu3JQcCgYAsfBSdq78j0D8/FB8hmGnyhpLE/uRRUZ8T6uOP
Cm+yw/DkQ0JnkBacWZ/mJYx0OfJB066CUIFO2oNqi27voYgl8hREWP39OICIzCAC
pYx+4bf/8DdGYdINPkLUhVp4dgnOx7tLhjpyf7Fi6s4WOLOS9sj2yjE6edhWwNOY
x8rzbQKBgBWtgbZxsdSL69kIM8nDOusBjqLPlrWEzeOjGR230okA5yT94/5fP5jc
lDcSCrZT/Uj1w0supBY6T15TtWW73WzaZpabP2FqOnTwqq/DBFdJ5igaiGtJdcp3
fYwArK1PZ7PSYBt7xq3aBYIK1PTIMNzCkbJfT1VoSJKkvxne5JH8",
		
		//异步通知地址
		'notify_url' => "http://wwww.aslegou.top/service/pay/notify",
		
		//同步跳转
		'return_url' => "http://wwww.aslegou.top/service/pay/call_back",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA14EC39x45R3m8h4MA2w7z+qiLo1XmU9h+Y+0rVPF2w1Xpiw7kxmWtCO8ldS/N30hEOJbFp/GSIzlJ4QPcFNZ2AP44SeyCeiIMoiBWcmnlDKC7Zcuyz/eFEU2RzlLU1af5BuLrljeJLtuYgTvoh+HQICCM/hD03YjXRD2Ti+txgZQ8g2bU4bEq4vdEyU7Rc3t0ogD4d17AIyBhw7qo7QzYYasYR919YZ1ghtBiSGEX41hLfBfs3uQgPJzt72I1NAA/6ixLzgi21PAQZTlBUQLU0OA8bUnX4cd2Xsu6pWvzjmWqkLtSgAETC+rEiJLJqhBslEkZ2bryFYG89WzB7d7HQIDAQAB",
		
	
);