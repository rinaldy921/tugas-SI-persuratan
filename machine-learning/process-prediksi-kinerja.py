import numpy as np
from flask import Flask, jsonify, request
from sklearn import preprocessing, neighbors
from sklearn.metrics import classification_report
from sklearn.model_selection import train_test_split
import pandas as pd

app = Flask(__name__)

@app.route('/calculate', methods=['POST'])
def calculate():
    data = request.args
    nip = data.get('nip')
    hari = data.get('hari')
    if nip is None:
        return jsonify({'code': 404, 'msg': 'NIP cannot blank.'})
    if hari is None:
        return jsonify({'code': 404, 'msg': 'Lama Proses cannot blank.'})
    df = pd.read_csv(r"C:\xampp-7.3\htdocs\tugas-SI-persuratan\machine-learning\Dataset.csv", header=None)
    df.columns = ['NIP', 'Lama-Proses', 'Kategori']
    Y = df['Kategori']
    X = df[['Lama-Proses']]
    X_train, X_test, Y_train, Y_test = train_test_split(X, Y, test_size=0.2)
    clf = neighbors.KNeighborsClassifier()
    clf.fit(X_train, Y_train)
    accuary = clf.score(X_test, Y_test)
    inputan = np.array([int(hari)])
    predict = inputan.reshape(1,-1)
    predict = clf.predict(predict)
  
    return jsonify({ 'result': {
        'nip': nip,
        'hari': hari,
        'predict': int(predict[0])
    }})


if __name__ == '__main__':
    app.run(debug=True, host= '0.0.0.0')