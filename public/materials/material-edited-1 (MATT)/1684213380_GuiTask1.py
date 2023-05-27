import pandas as pd
import numpy as np
from tkinter import *
from tkinter import Tk
from tkinter import ttk
from tkinter import filedialog
from tkinter import simpledialog
from sklearn.linear_model import LinearRegression
from sklearn.linear_model import Lasso
from sklearn.model_selection import train_test_split
class Colors:
    primaryColor = "#16191d"
    secondColor = "#2069A5"
    textColor = "white"

sizeTest = 0.0
landa=0.0
root = Tk(className="GuiTask1")
widthMe = root.winfo_screenwidth()
heightMe = root.winfo_screenheight()
root.state("zoomed")
root.iconbitmap("image/konan.png")
root.wm_minsize(768, heightMe)
root["bg"] = Colors.primaryColor


def light():
    Colors.primaryColor = "white"
    Colors.textColor = "black"
    print("primary = ",Colors.primaryColor)

def Dark():
    Colors.primaryColor = "#16191d"
    Colors.textColor = "white"
    print("primary = ",Colors.primaryColor)


def close():
    root.destroy()


def bd():
    print("press 1")

class att :
    dict ={"countery":["egypt","menofia"],
       "area":[10000,1500],
       "capital":["cairo","menof"]
       }

    tempFile=pd.DataFrame(dict)
    
def fileChoise():
    # ListTableData.delete(0,END)
    textchoise.delete(0, END)
    fd = ''
    fd = filedialog.askopenfilename(
        title="choise csv File ", initialdir="E:\\Year-3-Semester-2\\ML\\Section\\dataset", filetypes=(("csv files", "*.csv*"),))
    textchoise.insert(0, fd)
    if fd != '':

        textDiscribtion.delete("1.0", "end")
        if len(pd.read_csv(fd)) > 10000:
            tl = Toplevel(root)
            l = Label(tl, text="this file is very big ",
                      font=10, padx=20, pady=20)
            tl.geometry("500x500+500+300")
            l.pack()
            tl.mainloop()
        else:
            df = pd.read_csv(fd)
            att.tempFile=df
            l1 = list(df)
            r_set = df.to_numpy().tolist()
            ListTableData["columns"] = l1
            c = 0

            for i in l1:
                ListTableData.column(
                    i, width=100, stretch=False, minwidth=30, anchor="center")
                ListTableData.heading(i, text=i)
            tag="evenrow"
            for dt in r_set:
                v = [r for r in dt]
                try:
                    ListTableData.insert("", END, iid=v[0], values=v,tags=tag)
                except (Exception):
                    print("enter*************************************")
                    c += 1
                    continue
                tag ="evenrow" if tag=="oddrow" else "oddrow"
            
            print("count = ", c)
            textDiscribtion.insert(END, df.describe())
            


def keyup(e):
    if (e.char == 'x'):
        root.destroy()


def keydown(e):
    print(e.char)


def setSize(e):
    sizeTest = int(e)/100
    print(sizeTest)


def algMSE():
    radMSE.config(fg=Colors.secondColor)
    radRMSE.config(fg=Colors.textColor)
    radMAE.config(fg=Colors.textColor)
    trainEntry.delete(0,END)
    testEntry.delete(0,END)
    x=att.tempFile.iloc[:,:-1]
    y=att.tempFile.iloc[:,-1]
    sizeTest = int(sliderSize.get())/100
    x_train , x_test, y_train , y_test =train_test_split(x,y,test_size=sizeTest)
    landa=float(landaText.get())
    regr= Lasso(alpha=landa,normalize=TRUE)
    regr.fit(x_train,y_train)
    y_pred= regr.predict(x_test)
    y_pred_train=regr.predict(x_train)
    mseTest=np.square(np.subtract(y_test,y_pred)).mean()
    mseTrain=np.square(np.subtract(y_train,y_pred_train)).mean()
    trainEntry.insert(END,mseTrain)
    testEntry.insert(END,mseTest)

def algRMSE():
    radMSE.config(fg=Colors.textColor)
    radRMSE.config(fg=Colors.secondColor)
    radMAE.config(fg=Colors.textColor)
    trainEntry.delete(0,END)
    testEntry.delete(0,END)
    x=att.tempFile.iloc[:,:-1]
    y=att.tempFile.iloc[:,-1]
    
    sizeTest = int(sliderSize.get())/100
    x_train , x_test, y_train , y_test =train_test_split(x,y,test_size=sizeTest)
    landa=float(landaText.get())
    regr= Lasso(alpha=landa,normalize=TRUE)
    regr.fit(x_train,y_train)
    y_pred= regr.predict(x_test)
    y_pred_train=regr.predict(x_train)
    rmseTest=np.sqrt(np.square(np.subtract(y_test,y_pred)).mean())
    rmseTrain=np.sqrt(np.square(np.subtract(y_train,y_pred_train)).mean())
    trainEntry.insert(END,rmseTrain)
    testEntry.insert(END,rmseTest)



def algMAE():
    radMSE.config(fg=Colors.textColor)
    radRMSE.config(fg=Colors.textColor)
    radMAE.config(fg=Colors.secondColor)
    trainEntry.delete(0,END)
    testEntry.delete(0,END)
    x=att.tempFile.iloc[:,:-1]
    y=att.tempFile.iloc[:,-1]
    
    sizeTest = int(sliderSize.get())/100
    x_train , x_test, y_train , y_test =train_test_split(x,y,test_size=sizeTest)
    landa=float(landaText.get())
    regr= Lasso(alpha=landa,normalize=TRUE)
    regr.fit(x_train,y_train)
    y_pred= regr.predict(x_test)
    y_pred_train=regr.predict(x_train)
    maeTest=np.mean(np.abs(y_test-y_pred),axis=0)
    maeTrain=np.mean(np.abs(y_train-y_pred_train),axis=0)
    trainEntry.insert(END,maeTrain)
    testEntry.insert(END,maeTest)


root.bind("<KeyPress>", keydown)
root.bind("<KeyRelease>", keyup)

menuBar = Menu(root, background="red", fg=Colors.textColor)
fileMenu = Menu(menuBar, tearoff=0, background=Colors.primaryColor)
fileMenu.add_command(label="New file", command=fileChoise,
                     background=Colors.primaryColor, foreground=Colors.textColor)
fileMenu.add_separator(background=Colors.primaryColor)
fileMenu.add_command(label="Exit", command=close,
                     background=Colors.primaryColor, foreground=Colors.textColor)
menuBar.add_cascade(label="File", menu=fileMenu)

veiwMenu = Menu(menuBar, tearoff=0, background=Colors.primaryColor)
veiwMenu.add_command(label="Dark Mode", command=Dark,
                     background=Colors.primaryColor, foreground=Colors.textColor)
veiwMenu.add_command(label="Light Mode", command=light,
                     background=Colors.primaryColor, foreground=Colors.textColor)

menuBar.add_cascade(label="view", menu=veiwMenu)

root.config(menu=menuBar)

fTop = Frame(root, background=Colors.primaryColor, height=20)

fBottom = Frame(root, background=Colors.primaryColor, height=20)

fLeft = Frame(root, bg=Colors.primaryColor, borderwidth=3)
textchoise = Entry(fLeft, font=1, width=50,
                   background=Colors.primaryColor, foreground=Colors.textColor)
textchoise.focus_force()
btnCoise = Button(fLeft, command=fileChoise, text="select file",
                  font=.75, background=Colors.secondColor, foreground=Colors.textColor)
w=665
h=265
tableFrame = Frame(fLeft, background="red",width=w,height=h)

style1 = ttk.Style()
style1.theme_use('clam')
style1.configure("Horizontal.TScrollbar", background=Colors.secondColor,
                 bordercolor=Colors.secondColor, troughcolor=Colors.primaryColor, arrowcolor=Colors.secondColor)

style2 = ttk.Style()
style2.theme_use(themename='clam')
style2.configure("Vertical.TScrollbar", background=Colors.secondColor,
                 bordercolor=Colors.secondColor, troughcolor=Colors.primaryColor, arrowcolor=Colors.secondColor)
scH = ttk.Scrollbar(tableFrame, orient="horizontal",
                    style="Horizontal.TScrollbar")
scH.place(x=13,y=h-6,relwidth=.98,anchor="w",relheight=.05)

scV = ttk.Scrollbar(tableFrame, orient="vertical", style="Vertical.TScrollbar")
scV.place(x=0,y=265,relwidth=.02,anchor="sw",relheight=1)

style3 = ttk.Style()
style3.theme_use(themename='clam')
style3.configure("Treeview", background=Colors.primaryColor,foreground="red",rowhieght=55,
                 fieldbackground=Colors.primaryColor)
style3.map("Treeview",background=[('selected',Colors.secondColor)],foreground=[('selected',"black")])
style3.configure("Treeview.Heading",background=Colors.secondColor)
ListTableData = ttk.Treeview(tableFrame, show='headings',height=11,
                             selectmode="extended", yscrollcommand=scV.set, xscrollcommand=scH.set)
scV.configure(command=ListTableData.yview)
scH.configure(command=ListTableData.xview)
ListTableData.tag_configure(
                        "oddrow", background=Colors.primaryColor, foreground="white")
ListTableData.tag_configure(
                        "evenrow", background=Colors.secondColor, foreground="black")
ListTableData.place(x=13,y=0,relwidth=.98,relheight=.96)

lDiscribtion = Label(fLeft, text="Discription of Data ",
                     background=Colors.primaryColor, foreground=Colors.secondColor, font=1)
textDiscribtion = Text(fLeft, border=3, width=60, font=.75, height=13, background=Colors.primaryColor,
                       foreground=Colors.textColor, selectbackground=Colors.secondColor, state="normal")

fRight = Frame(root, background=Colors.primaryColor)
sizeLable = Label(fRight, text="Size test",
                  background=Colors.primaryColor, fg=Colors.textColor, font=1)
sliderSize = Scale(fRight, background=Colors.primaryColor, fg=Colors.textColor, length=600,
                   tickinterval=10, command=setSize, from_=0, to=100, orient="horizontal")
sliderSize.set(25)
regLable = Label(fRight, text="landa paramiter",
                 background=Colors.primaryColor, fg=Colors.textColor, font=1)
landaText = Entry(fRight, width=50, background=Colors.primaryColor,
                  fg=Colors.textColor, font=1)
landaText.insert(END,"0.1")
radMSE = Radiobutton(fRight, text="MSE", font=1, bg=Colors.primaryColor,
                     fg=Colors.textColor, command=algMSE, activebackground=Colors.secondColor, value=1)
radRMSE = Radiobutton(fRight, text="RMSE", font=1, bg=Colors.primaryColor,
                      fg=Colors.textColor, command=algRMSE, activebackground=Colors.secondColor, value=2)
radMAE = Radiobutton(fRight, text="MAE", font=1, bg=Colors.primaryColor,
                     fg=Colors.textColor, command=algMAE, activebackground=Colors.secondColor, value=3)
trainLabel = Label(fRight, text="Train", font=1, bg=Colors.primaryColor, fg=Colors.textColor)
trainEntry = Entry(fRight, font=1, bg=Colors.primaryColor, fg=Colors.textColor, width=50)
testLabel = Label(fRight, text="Test", font=1, bg=Colors.primaryColor, fg=Colors.textColor)
testEntry = Entry(fRight, font=1, bg=Colors.primaryColor, fg=Colors.textColor, width=50)

fTop.pack(side=TOP, fill="x")
fBottom.pack(side=BOTTOM)

fLeft.place(x=0, y=0, width=widthMe/2, height=heightMe)
textchoise.grid(column=0, row=0, sticky="w", pady=15, padx=5)
btnCoise.grid(column=1, row=0, sticky="w", pady=15)
tableFrame.grid(column=0, row=1, columnspan=2,
                rowspan=2, sticky="w", pady=15, padx=5)
lDiscribtion.grid(column=0, row=3, sticky="w", pady=15, padx=5)
textDiscribtion.grid(column=0, row=4, columnspan=2,
                     sticky="w", pady=15, padx=5)

fRight.place(x=widthMe/2, y=0, width=widthMe/2, height=heightMe)
sizeLable.grid(column=0, row=0, sticky="w", pady=20, padx=20)
sliderSize.grid(column=0, row=1, sticky="w", pady=20, padx=40, columnspan=2)
regLable.grid(column=0, row=2, sticky="w", pady=20, padx=20)
landaText.grid(column=0, row=3, sticky="w", padx=40)
radMSE.grid(column=0, row=4, sticky="w", padx=40, pady=30)
radRMSE.grid(column=0, row=5, sticky="w", padx=40)
radMAE.grid(column=0, row=6, sticky="w", padx=40, pady=30)
trainLabel.grid(column=0, row=7, sticky="w", padx=20, pady=20)
trainEntry.grid(column=0, row=8, sticky="w", padx=40)
testLabel.grid(column=0, row=9, sticky="w", padx=20, pady=20)
testEntry.grid(column=0, row=10, sticky="w", padx=40)

root.mainloop()