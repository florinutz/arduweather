import pandas as pd
import matplotlib.pyplot as plt

def test_run():
    df = pd.read_csv("data/sensor.csv")
    print df[['Light','Humidity Ground']]
    df[['Light','Humidity Ground']].plot()
    plt.title('Close Price For APPLE')
    plt.xlabel('Index')
    plt.ylabel('Close Price')
    plt.show()
#Light,Humidity Ground,Humidity Air,Temperature

if __name__ == "__main__":
    test_run()