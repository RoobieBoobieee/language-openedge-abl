import csv
with open('data.csv', newline='') as csvfile:
    data = csv.reader(csvfile, delimiter=';', quotechar='"')
        for row in data:
            handleData(row)

def handleData(row):
    print(', '.join(row))
