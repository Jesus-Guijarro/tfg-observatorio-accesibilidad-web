import os,sys

from crontab import CronTab
from datetime import datetime  

#Argumentos
class Person:
  def __init__(self, name, age):
    self.name = name
    self.age = age

  def myfunc(self):
    print("Hello my name is " + self.name)
