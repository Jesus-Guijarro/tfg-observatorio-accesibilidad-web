def f():

    try:

        a = 2+b
        return "AAA"

    except Exception as e:
        pass


a = f()

if a:
    print("A")