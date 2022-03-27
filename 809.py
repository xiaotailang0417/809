# encoding:utf-8
import hashlib,requests,json

def MD5(string = 'ikommql45'):
    """将string值进行MD5加密"""
    md5 = hashlib.md5()         
    md5.update(string.encode('utf-8'))        
    keyRes = md5.hexdigest()        
    print("加密前："+string)
    print("加密后："+keyRes)
    return keyRes

str = "if5ax/?fakeid=nYkyzjSrtNKGi8CvWQGhaC&spid=81117&pid=81117&spip=121.22.5.6&spport=443&ugpid=811173d99ff138e1f41e931e58617e7d128e2"

spkey = MD5(str)

url = f"http://dir.v.wo.cn:809/if5ax/?fakeid=nYkyzjSrtNKGi8CvWQGhaC&spid=81117&pid=81117&spip=121.22.5.6&spport=443&ugpid=81117&spkey={spkey}"
#print(url)
resp = requests.get(url)
url = resp.json()['url']
#print(url)

